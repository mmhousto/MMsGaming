<style>
<?php include 'basic.css'; ?>
</style>
<?php 
require_once "config.php";

function setComments($link) {
    if (isset($_POST['commentSubmit']) && ($user = comment_user()) && ($message = comment_message()) !== null) {
        db_query($link, "INSERT INTO comments (uid, date, message) VALUES (?, ?, ?)", [$user, date('Y-m-d H:i:s'), $message]);
    }
}

function getComments($link) {
    $sql = "SELECT * FROM comments";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $uid = $row['uid'];
        $sql2 = "SELECT * FROM users WHERE username =?";
        $result2 = db_query($link, $sql2, [$uid]);
        if ($row2 = mysqli_fetch_assoc($result2)) {
        echo "<div class='comment-box'><p style='font-family: arial; font-size: 14px; line-height: 16px; font-weight: 100;'>";
        echo e($row2['username'])."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
        echo "Posted on: ".e($row['date'])."<br><br>";
        echo nl2br(e($row['message']))."<br><br><br>";
        echo "</p>";
        if (isset($_SESSION['id'])) {
            if ($_SESSION['id'] == $row2['id']) {
                echo "<form style='position: absolute; top:0px; right:50px;' method='POST' action='".deleteComments($link)."'>
                    <input type='hidden' name='cid' value='".e($row['cid'])."'>
                    <button class='delete-btn' type='submit' name='deleteSubmit'>Delete</button>
                </form>
                <form style='position: absolute; top:0px; right:0px;' method='POST' action='../editComment.php' onsubmit='target_popup(this)'>
                    <input type='hidden' name='cid' value='".e($row['cid'])."'>
                    <input type='hidden' name='uid' value='".e($row['uid'])."'>
                    <input type='hidden' name='date' value='".e($row['date'])."'>
                    <input type='hidden' name='message' value='".e($row['message'])."'>
                    <button class='edit-btn' name='edit'>Edit</button>
                </form>";
            } else {
                echo "<form style='position: absolute; bottom:0px; left:0px;' method='POST' action='../replyComment.php' onsubmit='target_popup(this)'>
                    <input type='hidden' name='cid' value='".e($row['cid'])."'>
                    <button class='reply-btn' name='reply'>Reply</button>
                </form>";
            }
        } else {
            
        }
        echo "</div>";
        }
        $cid = $row['cid'];
        $sql3 = "SELECT * FROM replies WHERE cid = ?";
        $result3 = db_query($link, $sql3, [$cid]);
        while ($row3 = mysqli_fetch_assoc($result3)) {
            $uid = $row3['uid'];
            $sql4 = "SELECT * FROM users WHERE username =?";
            $result4 = db_query($link, $sql4, [$uid]);
            if ($row4 = mysqli_fetch_assoc($result4)) {
            echo "<div class='comment-box' style='left: 10%; width: 90%;'><p style='font-family: arial; font-size: 14px; line-height: 16px; font-weight: 100;'>";
            echo e($row3['uid'])."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
            echo "Posted on: ".e($row3['date'])."<br><br>";
            echo nl2br(e($row3['message']))."<br><br><br>";
            echo "</p>";
            if (isset($_SESSION['id'])) {
                if ($_SESSION['id'] == $row4['id']) {
                    echo "<form style='position: absolute; top:0px; right:50px;' method='POST' action='".deleteReplies($link)."'>
                    <input type='hidden' name='rid' value='".e($row3['rid'])."'>
                    <button class='delete-btn' type='submit' name='deleteRSubmit'>Delete</button>
                    </form>
                    <form style='position: absolute; top:0px; right:0px;' method='POST' action='../editReply.php' onsubmit='target_popup(this)'>
                        <input type='hidden' name='rid' value='".e($row3['rid'])."'>
                        <input type='hidden' name='uid' value='".e($row3['uid'])."'>
                        <input type='hidden' name='date' value='".e($row3['date'])."'>
                        <input type='hidden' name='message' value='".e($row3['message'])."'>
                        <button class='edit-btn' name='editR'>Edit</button>
                    </form>";
                } else {
                    echo "<form style='position: absolute; bottom:0px; left:0px;' method='POST' action='../replyReply.php' onsubmit='target_popup(this)'>
                        <input type='hidden' name='rid' value='".e($row3['rid'])."'>
                        <input type='hidden' name='cid' value='".e($row3['cid'])."'>
                        <button class='reply-btn' name='replyR'>Reply</button>
                    </form>";
                }
            } else {
            
            }
            echo "</div>";
            }
            $rid = $row3['rid'];
            $sql5 = "SELECT * FROM secondReplies WHERE rid = ?";
            $result5 = db_query($link, $sql5, [$rid]);
        while ($row5 = mysqli_fetch_assoc($result5)) {
            $uid = $row5['uid'];
            $sql6 = "SELECT * FROM users WHERE username =?";
            $result6 = db_query($link, $sql6, [$uid]);
            if ($row6 = mysqli_fetch_assoc($result6)) {
            echo "<div class='comment-box' style='left: 20%; width: 80%;'><p style='font-family: arial; font-size: 14px; line-height: 16px; font-weight: 100;'>";
            echo e($row5['uid'])."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
            echo "Posted on: ".e($row5['date'])."<br><br>";
            echo nl2br(e($row5['message']))."<br><br><br>";
            echo "</p>";
            if (isset($_SESSION['id'])) {
                if ($_SESSION['id'] == $row6['id']) {
                    echo "<form style='position: absolute; top:0px; right:50px;' method='POST' action='".deleteSReplies($link)."'>
                    <input type='hidden' name='srid' value='".e($row5['srid'])."'>
                    <button class='delete-btn' type='submit' name='deleteSRSubmit'>Delete</button>
                    </form>
                    <form style='position: absolute; top:0px; right:0px;' method='POST' action='../editSReply.php' onsubmit='target_popup(this)'>
                        <input type='hidden' name='srid' value='".e($row5['srid'])."'>
                        <input type='hidden' name='uid' value='".e($row5['uid'])."'>
                        <input type='hidden' name='date' value='".e($row5['date'])."'>
                        <input type='hidden' name='message' value='".e($row5['message'])."'>
                        <button class='edit-btn' name='editSR'>Edit</button>
                    </form>";
                } else {
                    
                }
            } else {
            
            }
            echo "</div>";
            }
        
        }
        
        }
    }
    
}


// All comment writes use the logged-in user from the session (never a
// user id sent by the form), set the date on the server, and only let
// people edit or delete their own posts.
function comment_user() {
    return (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && !empty($_SESSION['username']))
        ? (string) $_SESSION['username'] : null;
}

function comment_message() {
    $message = trim((string) ($_POST['message'] ?? ''));
    return ($message === '' || strlen($message) > 5000) ? null : $message;
}

function comment_done($text) {
    echo "<script>";
    echo 'alert(' . js($text) . ');';
    echo 'window.opener.location.reload();
        window.close();';
    echo "</script>";
}

function editComments($link) {
    if (isset($_POST['editSubmit']) && ($user = comment_user()) && ($message = comment_message()) !== null) {
        db_query($link, "UPDATE comments SET message = ? WHERE cid = ? AND uid = ?", [$message, (int) ($_POST['cid'] ?? 0), $user]);
        comment_done("Comment updated!");
    }
}

function editReplies($link) {
    if (isset($_POST['editRSubmit']) && ($user = comment_user()) && ($message = comment_message()) !== null) {
        db_query($link, "UPDATE replies SET message = ? WHERE rid = ? AND uid = ?", [$message, (int) ($_POST['rid'] ?? 0), $user]);
        comment_done("Reply updated!");
    }
}

function editSReplies($link) {
    if (isset($_POST['editSRSubmit']) && ($user = comment_user()) && ($message = comment_message()) !== null) {
        db_query($link, "UPDATE secondReplies SET message = ? WHERE srid = ? AND uid = ?", [$message, (int) ($_POST['srid'] ?? 0), $user]);
        comment_done("Reply updated!");
    }
}

function deleteComments($link) {
    if (isset($_POST['deleteSubmit']) && ($user = comment_user())) {
        $cid = (int) ($_POST['cid'] ?? 0);
        db_query($link, "DELETE FROM comments WHERE cid = ? AND uid = ?", [$cid, $user]);
        if (db_affected_rows() === 1) {
            db_query($link, "DELETE FROM replies WHERE cid = ?", [$cid]);
            db_query($link, "DELETE FROM secondReplies WHERE cid = ?", [$cid]);
        }
    }
}

function deleteReplies($link) {
    if (isset($_POST['deleteRSubmit']) && ($user = comment_user())) {
        $rid = (int) ($_POST['rid'] ?? 0);
        db_query($link, "DELETE FROM replies WHERE rid = ? AND uid = ?", [$rid, $user]);
        if (db_affected_rows() === 1) {
            db_query($link, "DELETE FROM secondReplies WHERE rid = ?", [$rid]);
        }
    }
}

function deleteSReplies($link) {
    if (isset($_POST['deleteSRSubmit']) && ($user = comment_user())) {
        db_query($link, "DELETE FROM secondReplies WHERE srid = ? AND uid = ?", [(int) ($_POST['srid'] ?? 0), $user]);
    }
}

function replyComments($link) {
    if (isset($_POST['replySubmit']) && ($user = comment_user()) && ($message = comment_message()) !== null) {
        db_query($link, "INSERT INTO replies (cid, uid, date, message) VALUES (?, ?, ?, ?)",
            [(int) ($_POST['cid'] ?? 0), $user, date('Y-m-d H:i:s'), $message]);
        comment_done("Replied to a comment!");
    }
}

function replyReplies($link) {
    if (isset($_POST['replyRSubmit']) && ($user = comment_user()) && ($message = comment_message()) !== null) {
        db_query($link, "INSERT INTO secondReplies (rid, cid, uid, date, message) VALUES (?, ?, ?, ?, ?)",
            [(int) ($_POST['rid'] ?? 0), (int) ($_POST['cid'] ?? 0), $user, date('Y-m-d H:i:s'), $message]);
        comment_done("Replied to a reply!");
    }
}

?>

<script>
function target_popup(form) {
    window.open('', 'formpopup', 'width=800,height=400,resizeable,scrollbars');
    form.target = 'formpopup';
}
</script>