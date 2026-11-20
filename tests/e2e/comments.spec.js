// Blog comments: who can post, edit and delete, and safe display.
const { test, expect } = require('@playwright/test');
const { registerUser, login } = require('../helpers/site');
const { query, scalar, mysql, q } = require('../helpers/db');

const BLOG = '/blog/Best-Io-Games.php';

async function player(playwright, baseURL) {
  const ctx = await playwright.request.newContext({ baseURL });
  const name = await registerUser(ctx);
  await login(ctx, name);
  return { ctx, name };
}

function commentsBy(name) {
  return query(`SELECT cid, message FROM comments WHERE uid = ${q(name)} ORDER BY cid`);
}

test.beforeEach(() => mysql('DELETE FROM comments; DELETE FROM replies; DELETE FROM secondReplies;'));

test('a comment is saved under the logged-in player, whatever the form says', async ({ playwright, baseURL }) => {
  const alice = await player(playwright, baseURL);
  const bob = await player(playwright, baseURL);

  await alice.ctx.post(BLOG, { form: { commentSubmit: '1', uid: bob.name, date: '1999-01-01', message: 'hello' } });

  expect(commentsBy(bob.name)).toHaveLength(0);
  expect(commentsBy(alice.name)).toHaveLength(1);
  expect(scalar(`SELECT YEAR(date) FROM comments WHERE uid = ${q(alice.name)}`)).not.toBe('1999');
});

test('guests cannot post comments', async ({ request }) => {
  await request.post(BLOG, { form: { commentSubmit: '1', uid: 'someone', message: 'guest post' } });
  expect(scalar('SELECT COUNT(*) FROM comments')).toBe('0');
});

test("players cannot edit or delete someone else's comment", async ({ playwright, baseURL }) => {
  const alice = await player(playwright, baseURL);
  const bob = await player(playwright, baseURL);
  await bob.ctx.post(BLOG, { form: { commentSubmit: '1', message: "Bob's comment" } });
  const [[cid]] = commentsBy(bob.name);

  await alice.ctx.post(BLOG, { form: { deleteSubmit: '1', cid } });
  await alice.ctx.post('/editComment.php', { form: { editSubmit: '1', cid, uid: bob.name, message: 'hacked' } });

  expect(commentsBy(bob.name)).toEqual([[cid, "Bob's comment"]]);
});

test('players can edit and delete their own comment (and its replies go with it)', async ({ playwright, baseURL }) => {
  const alice = await player(playwright, baseURL);
  const bob = await player(playwright, baseURL);
  await alice.ctx.post(BLOG, { form: { commentSubmit: '1', message: 'first version' } });
  const [[cid]] = commentsBy(alice.name);

  await alice.ctx.post('/editComment.php', { form: { editSubmit: '1', cid, message: 'second version' } });
  expect(commentsBy(alice.name)).toEqual([[cid, 'second version']]);

  await bob.ctx.post('/replyComment.php', { form: { replySubmit: '1', cid, uid: alice.name, message: 'nice' } });
  expect(query(`SELECT uid, message FROM replies WHERE cid = ${cid}`)).toEqual([[bob.name, 'nice']]);

  await alice.ctx.post(BLOG, { form: { deleteSubmit: '1', cid } });
  expect(scalar('SELECT COUNT(*) FROM comments')).toBe('0');
  expect(scalar('SELECT COUNT(*) FROM replies')).toBe('0');
});

test('comment text is shown as text, not run as code', async ({ playwright, baseURL }) => {
  const alice = await player(playwright, baseURL);
  await alice.ctx.post(BLOG, { form: { commentSubmit: '1', message: '<img src=x onerror=alert(66)>' } });
  const body = await (await alice.ctx.get(BLOG)).text();
  expect(body).not.toContain('<img src=x onerror=alert(66)>');
  expect(body).toContain('&lt;img src=x onerror=alert(66)&gt;');
});
