-- Blog post: The Game Awards 2026, Best Independent Game nominees.
--
-- Safe to run more than once: it removes any earlier copy of this post, then
-- inserts the current version. "posted" (a DATE) is set to the day you run it,
-- in US Central time (CST, UTC-6; change '-06:00' to '-05:00' during CDT).
--
-- Images live in /blog/images/tga-2026-indie/ (official Steam store art and
-- screenshots from each game's developer or publisher).
DELETE FROM posts WHERE href = 'Game-Awards-2026-Best-Independent-Game-Nominees.php';

INSERT INTO posts (title, summary, posted, image, alt, href, author, content) VALUES (
  'The Game Awards 2026: Meet the Best Independent Game Nominees',
  'Big Walk, Cairn, Denshattack!, Mewgenics and Mina the Hollower are going head to head for Best Independent Game at The Game Awards 2026. Here is everything you need to know about all five, plus our pick to win.',
  DATE(CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '-06:00')),
  '/blog/images/tga-2026-indie/tga-2026-indie-feature.jpg',
  'The Game Awards 2026 Best Independent Game nominees',
  'Game-Awards-2026-Best-Independent-Game-Nominees.php',
  'MM''s Gaming Co. Staff',
  '<div class="post">

<p class="post-lede">Indie games had a massive year, and The Game Awards just made it official! The nominees for <strong>Best Independent Game</strong> were revealed on November 17, and what a lineup it is: a cozy co-op stroll, a nail-biting climb, a train that does kickflips, an army of cats and a brand new adventure from the Shovel Knight team.</p>

<p>The winner will be crowned at The Game Awards on <strong>December 10</strong> at the Peacock Theater in Los Angeles. Until then, here is a closer look at all five nominees.</p>

<figure>
  <div class="post-video">
    <iframe src="https://www.youtube-nocookie.com/embed/_e0oJSfmIFU" title="The Game Awards 2026 nominee reveal" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
  </div>
  <figcaption>The Game Awards 2026 nominee reveal. Video: The Game Awards</figcaption>
</figure>

<ol class="post-toc">
  <li><a href="#big-walk">Big Walk</a>: a cooperative walker-talker from the makers of Untitled Goose Game</li>
  <li><a href="#cairn">Cairn</a>: a survival climber from the creators of Furi and Haven</li>
  <li><a href="#denshattack">Denshattack!</a>: trick, flip and grind your train</li>
  <li><a href="#mewgenics">Mewgenics</a>: breed the ultimate cat army</li>
  <li><a href="#mina">Mina the Hollower</a>: the new adventure from the Shovel Knight team</li>
</ol>

<h2 id="big-walk">Big Walk</h2>
<ul class="post-game-meta">
  <li><strong>Developer:</strong> House House</li>
  <li><strong>Publisher:</strong> Panic</li>
  <li><strong>Released:</strong> Aug 4, 2026</li>
  <li><strong>Platforms:</strong> PC, Mac</li>
  <li><strong>Metacritic:</strong> 91</li>
</ul>
<p>The team behind Untitled Goose Game is back, and this time they want you to bring friends. Big Walk is a cooperative online &ldquo;walker-talker&rdquo; where you hang out and get lost together in a big, beautiful world. It is the kind of game where the best moments happen in the conversations along the way. It is also one of the most-nominated indies of the night, with nods in Best Family, Best Multiplayer and Games for Impact too.</p>
<div class="post-grid">
  <figure>
    <img src="/blog/images/tga-2026-indie/big-walk.jpg" alt="Colorful Big Walk characters gathered on a stage at sunset" loading="lazy" width="1100" height="619">
    <figcaption>Image: House House / Panic</figcaption>
  </figure>
  <figure>
    <div class="post-video">
      <iframe src="https://www.youtube-nocookie.com/embed/7ZYjg_jPhDk" title="Big Walk is out now" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <figcaption>Launch trailer. Video: House House</figcaption>
  </figure>
</div>
<p><a class="post-play-btn" href="https://store.steampowered.com/app/1478500/" target="_blank" rel="noopener">Big Walk on Steam</a></p>

<h2 id="cairn">Cairn</h2>
<ul class="post-game-meta">
  <li><strong>Developer and publisher:</strong> The Game Bakers</li>
  <li><strong>Released:</strong> Jan 29, 2026</li>
  <li><strong>Platforms:</strong> PC</li>
</ul>
<p>Cairn asks one simple question: can you reach a summit nobody has ever climbed? From the creators of Furi and Haven, this survival-climber lets you climb anywhere, but you have to plan every route, manage your pitons and resources, and survive the unforgiving Mount Kami. Every handhold feels earned, and reaching the top feels incredible.</p>
<div class="post-grid">
  <figure>
    <img src="/blog/images/tga-2026-indie/cairn.jpg" alt="A climber clinging to a sheer rock face high above the clouds in Cairn" loading="lazy" width="1100" height="619">
    <figcaption>Image: The Game Bakers</figcaption>
  </figure>
  <figure>
    <div class="post-video">
      <iframe src="https://www.youtube-nocookie.com/embed/6Ejphz8fY0A" title="Cairn launch trailer" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <figcaption>Launch trailer. Video: The Game Bakers</figcaption>
  </figure>
</div>
<p><a class="post-play-btn" href="https://store.steampowered.com/app/1588550/" target="_blank" rel="noopener">Cairn on Steam</a></p>

<h2 id="denshattack">Denshattack!</h2>
<ul class="post-game-meta">
  <li><strong>Developer:</strong> Undercoders</li>
  <li><strong>Publishers:</strong> Fireshine Games and Boltray Games</li>
  <li><strong>Released:</strong> Jul 15, 2026</li>
  <li><strong>Platforms:</strong> PC, PS5, Nintendo Switch 2</li>
  <li><strong>Metacritic:</strong> 88</li>
</ul>
<p>What if a skateboarding game, but the skateboard is a train? Denshattack! lets you flip, trick and grind your train through a colorful Japanese dystopia, outmatching rival gangs and taking on a shady megacorp along the way. It is fast, stylish and completely unlike anything else on this list.</p>
<div class="post-grid">
  <figure>
    <img src="/blog/images/tga-2026-indie/denshattack.jpg" alt="A yellow train grinding along a rail at high speed in Denshattack!" loading="lazy" width="1100" height="619">
    <figcaption>Image: Undercoders / Fireshine Games</figcaption>
  </figure>
  <figure>
    <div class="post-video">
      <iframe src="https://www.youtube-nocookie.com/embed/1MUuSW4g0Bc" title="Denshattack! release date trailer" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <figcaption>Release date trailer. Video: Fireshine Games</figcaption>
  </figure>
</div>
<p><a class="post-play-btn" href="https://store.steampowered.com/app/2524850/" target="_blank" rel="noopener">Denshattack! on Steam</a></p>

<h2 id="mewgenics">Mewgenics</h2>
<ul class="post-game-meta">
  <li><strong>Developers:</strong> Edmund McMillen and Tyler Glaiel</li>
  <li><strong>Released:</strong> Feb 10, 2026</li>
  <li><strong>Platforms:</strong> PC</li>
  <li><strong>Metacritic:</strong> 88</li>
</ul>
<p>From the creators of The Binding of Isaac and The End is Nigh comes a game about breeding the ultimate cat army. Seriously! In Mewgenics you draft abilities, collect items and manipulate genetics across generations, then send your cats into deep, challenging turn-based adventures. It is weird, wonderful and dangerously hard to stop playing.</p>
<div class="post-grid">
  <figure>
    <img src="/blog/images/tga-2026-indie/mewgenics.jpg" alt="A turn-based battle in a dark cave in Mewgenics" loading="lazy" width="1100" height="619">
    <figcaption>Image: Edmund McMillen / Tyler Glaiel</figcaption>
  </figure>
  <figure>
    <div class="post-video">
      <iframe src="https://www.youtube-nocookie.com/embed/FhxmMH8VohA" title="Mewgenics release date trailer" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <figcaption>Release date trailer. Video: Edmund McMillen</figcaption>
  </figure>
</div>
<p><a class="post-play-btn" href="https://store.steampowered.com/app/686060/" target="_blank" rel="noopener">Mewgenics on Steam</a></p>

<h2 id="mina">Mina the Hollower</h2>
<ul class="post-game-meta">
  <li><strong>Developer and publisher:</strong> Yacht Club Games</li>
  <li><strong>Released:</strong> May 28, 2026</li>
  <li><strong>Platforms:</strong> PC, Mac, Linux, PS5, Nintendo Switch 2</li>
  <li><strong>Metacritic:</strong> 90</li>
</ul>
<p>The Shovel Knight team strikes again! You play as Mina, a renowned Hollower sent on a desperate mission to rescue a cursed island. Whip your foes, burrow through the ground and explore a gorgeous, pixel-perfect world. If you grew up on classic handheld adventures, this one will feel like coming home.</p>
<div class="post-grid">
  <figure>
    <img src="/blog/images/tga-2026-indie/mina.jpg" alt="Mina exploring a pixel-art dungeon in Mina the Hollower" loading="lazy" width="1100" height="619">
    <figcaption>Image: Yacht Club Games</figcaption>
  </figure>
  <figure>
    <div class="post-video">
      <iframe src="https://www.youtube-nocookie.com/embed/-Kx17VN7x9A" title="Mina the Hollower launch trailer" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <figcaption>Launch trailer. Video: Nintendo of America</figcaption>
  </figure>
</div>
<p><a class="post-play-btn" href="https://store.steampowered.com/app/1875580/" target="_blank" rel="noopener">Mina the Hollower on Steam</a></p>

<h2>Our pick</h2>
<div class="post-tip"><p><strong>Who we think will win: Big Walk.</strong> It has the highest Metacritic score of the bunch on Steam (91) and shows up in four categories, which tells you how much the industry loves it. House House already proved with Untitled Goose Game that a simple idea can become a phenomenon, and Big Walk feels like that magic all over again, this time with your friends along for the ride.</p></div>
<div class="post-tip"><p><strong>Our heart pick: Mewgenics.</strong> It is gloriously strange, deeper than it has any right to be, and we have lost far too many evenings to &ldquo;just one more generation.&rdquo; We would love to see it take home the trophy.</p></div>
<p>Honestly, though, there is no wrong answer this year. Every one of these games is worth your time, and that is the best news indie fans could ask for.</p>

<div class="post-callout">
  <figure>
    <img src="/blog/images/indie-picks-nov-2026/imprecision.jpg" alt="First-person view of a bow aimed at an archery target in Imprecision&rsquo;s voxel world" loading="lazy" width="800" height="450">
  </figure>
  <div>
    <h3>Support indie games, starting with ours</h3>
    <p>Here at MM&rsquo;s Gaming Co. we make indie games too! <strong>Imprecision</strong> is our action-adventure roguelite set in the Middle Ages, where you play as a lone archer taking on King Bj&oslash;rn the Bloodthirsty. It is on Steam for $4.99.</p>
    <p><a class="post-play-btn" href="https://store.steampowered.com/app/2466820/" target="_blank" rel="noopener">Imprecision on Steam</a></p>
  </div>
</div>

<h2>Your turn!</h2>
<p>Who are you rooting for? Have you played all five, or is there a nominee you are adding to your list now? Tell us in the comments, and come back after December 10 for our reaction to the winners. Happy gaming!</p>

<div class="post-sources">
  <h2>Sources</h2>
  <ul>
    <li><a href="https://gameinformer.com/2026/11/17/here-are-the-nominees-for-the-game-awards-2026" target="_blank" rel="noopener">Game Informer: Here are the nominees for The Game Awards 2026</a></li>
    <li><a href="https://nichegamer.com/the-game-awards-2026-reveals-its-best-independent-game-nominees/" target="_blank" rel="noopener">Niche Gamer: The Game Awards 2026 reveals its Best Independent Game nominees</a></li>
    <li><a href="https://variety.com/2026/awards/news/game-awards-nominations-2026-list-1236949480/" target="_blank" rel="noopener">Variety: The Game Awards nominations 2026</a></li>
    <li>Steam store pages: <a href="https://store.steampowered.com/app/1478500/" target="_blank" rel="noopener">Big Walk</a>, <a href="https://store.steampowered.com/app/1588550/" target="_blank" rel="noopener">Cairn</a>, <a href="https://store.steampowered.com/app/2524850/" target="_blank" rel="noopener">Denshattack!</a>, <a href="https://store.steampowered.com/app/686060/" target="_blank" rel="noopener">Mewgenics</a>, <a href="https://store.steampowered.com/app/1875580/" target="_blank" rel="noopener">Mina the Hollower</a></li>
  </ul>
  <p>Release dates, developers and Metacritic scores are from each game&rsquo;s Steam store page. Platforms list what we could confirm from official store pages and launch trailers. Screenshots and trailers belong to each game&rsquo;s developer and publisher.</p>
</div>

</div>'
);
