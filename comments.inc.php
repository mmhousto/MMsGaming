<style>
<?php include 'basic.css'; ?>
</style>
<?php 
require_once "config.php";

function setComments($link) {
    if (isset($_POST['commentSubmit'])) {
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];
        
        $sql = "INSERT INTO comments (uid, date, message) VALUES ('$uid', '$date', '".mysqli_real_escape_string($link, $message)."')";
        $result = mysqli_query($link, $sql);
    }
    
}

function getComments($link) {
    $sql = "SELECT * FROM comments";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $uid = $row['uid'];
        $sql2 = "SELECT * FROM users WHERE username ='$uid'";
        $result2 = mysqli_query($link, $sql2);
        if ($row2 = mysqli_fetch_assoc($result2)) {
        echo "<div class='comment-box'><p style='font-family: arial; font-size: 14px; line-height: 16px; font-weight: 100;'>";
        echo $row2['username']."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
        echo "Posted on: ".$row['date']."<br><br>";
        echo nl2br($row['message'])."<br><br><br>";
        echo "</p>";
        if (isset($_SESSION['id'])) {
            if ($_SESSION['id'] == $row2['id']) {
                echo "<form style='position: absolute; top:0px; right:50px;' method='POST' action='".deleteComments($link)."'>
                    <input type='hidden' name='cid' value='".$row['cid']."'>
                    <button class='delete-btn' type='submit' name='deleteSubmit'>Delete</button>
                </form>
                <form style='position: absolute; top:0px; right:0px;' method='POST' action='../editComment.php' onsubmit='target_popup(this)'>
                    <input type='hidden' name='cid' value='".$row['cid']."'>
                    <input type='hidden' name='uid' value='".$row['uid']."'>
                    <input type='hidden' name='date' value='".$row['date']."'>
                    <input type='hidden' name='message' value='".$row['message']."'>
                    <button class='edit-btn' name='edit'>Edit</button>
                </form>";
            } else {
                echo "<form style='position: absolute; bottom:0px; left:0px;' method='POST' action='../replyComment.php' onsubmit='target_popup(this)'>
                    <input type='hidden' name='cid' value='".$row['cid']."'>
                    <button class='reply-btn' name='reply'>Reply</button>
                </form>";
            }
        } else {
            
        }
        echo "</div>";
        }
        $cid = $row['cid'];
        $sql3 = "SELECT * FROM replies WHERE cid = '$cid'";
        $result3 = mysqli_query($link, $sql3);
        while ($row3 = mysqli_fetch_assoc($result3)) {
            $uid = $row3['uid'];
            $sql4 = "SELECT * FROM users WHERE username ='$uid'";
            $result4 = mysqli_query($link, $sql4);
            if ($row4 = mysqli_fetch_assoc($result4)) {
            echo "<div class='comment-box' style='left: 10%; width: 90%;'><p style='font-family: arial; font-size: 14px; line-height: 16px; font-weight: 100;'>";
            echo $row3['uid']."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
            echo "Posted on: ".$row3['date']."<br><br>";
            echo nl2br($row3['message'])."<br><br><br>";
            echo "</p>";
            if (isset($_SESSION['id'])) {
                if ($_SESSION['id'] == $row4['id']) {
                    echo "<form style='position: absolute; top:0px; right:50px;' method='POST' action='".deleteReplies($link)."'>
                    <input type='hidden' name='rid' value='".$row3['rid']."'>
                    <button class='delete-btn' type='submit' name='deleteRSubmit'>Delete</button>
                    </form>
                    <form style='position: absolute; top:0px; right:0px;' method='POST' action='../editReply.php' onsubmit='target_popup(this)'>
                        <input type='hidden' name='rid' value='".$row3['rid']."'>
                        <input type='hidden' name='uid' value='".$row3['uid']."'>
                        <input type='hidden' name='date' value='".$row3['date']."'>
                        <input type='hidden' name='message' value='".$row3['message']."'>
                        <button class='edit-btn' name='editR'>Edit</button>
                    </form>";
                } else {
                    echo "<form style='position: absolute; bottom:0px; left:0px;' method='POST' action='../replyReply.php' onsubmit='target_popup(this)'>
                        <input type='hidden' name='rid' value='".$row3['rid']."'>
                        <input type='hidden' name='cid' value='".$row3['cid']."'>
                        <button class='reply-btn' name='replyR'>Reply</button>
                    </form>";
                }
            } else {
            
            }
            echo "</div>";
            }
            $rid = $row3['rid'];
            $sql5 = "SELECT * FROM secondReplies WHERE rid = '$rid'";
            $result5 = mysqli_query($link, $sql5);
        while ($row5 = mysqli_fetch_assoc($result5)) {
            $uid = $row5['uid'];
            $sql6 = "SELECT * FROM users WHERE username ='$uid'";
            $result6 = mysqli_query($link, $sql6);
            if ($row6 = mysqli_fetch_assoc($result6)) {
            echo "<div class='comment-box' style='left: 20%; width: 80%;'><p style='font-family: arial; font-size: 14px; line-height: 16px; font-weight: 100;'>";
            echo $row5['uid']."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
            echo "Posted on: ".$row5['date']."<br><br>";
            echo nl2br($row5['message'])."<br><br><br>";
            echo "</p>";
            if (isset($_SESSION['id'])) {
                if ($_SESSION['id'] == $row6['id']) {
                    echo "<form style='position: absolute; top:0px; right:50px;' method='POST' action='".deleteSReplies($link)."'>
                    <input type='hidden' name='srid' value='".$row5['srid']."'>
                    <button class='delete-btn' type='submit' name='deleteSRSubmit'>Delete</button>
                    </form>
                    <form style='position: absolute; top:0px; right:0px;' method='POST' action='../editSReply.php' onsubmit='target_popup(this)'>
                        <input type='hidden' name='srid' value='".$row5['srid']."'>
                        <input type='hidden' name='uid' value='".$row5['uid']."'>
                        <input type='hidden' name='date' value='".$row5['date']."'>
                        <input type='hidden' name='message' value='".$row5['message']."'>
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


function editComments($link) {
        if (isset($_POST['editSubmit'])) {
        $cid = $_POST['cid'];
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];
        
        $sql = "UPDATE comments SET message = '".mysqli_real_escape_string($link, $message)."' WHERE cid = '$cid'";
        $result = mysqli_query($link, $sql);
        echo "<script>";
        echo 'alert("Comment updated!");';
        echo 'window.opener.location.reload();
        window.close();';
        echo "</script>";
    }
    
}

function editReplies($link) {
        if (isset($_POST['editRSubmit'])) {
        $rid = $_POST['rid'];
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];
        
        $sql = "UPDATE replies SET message = '".mysqli_real_escape_string($link, $message)."' WHERE rid = '$rid'";
        $result = mysqli_query($link, $sql);
        echo "<script>";
        echo 'alert("Reply updated!");';
        echo 'window.opener.location.reload();
        window.close();';
        echo "</script>";
    }
    
}

function editSReplies($link) {
        if (isset($_POST['editSRSubmit'])) {
        $srid = $_POST['srid'];
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];
        
        $sql = "UPDATE secondReplies SET message = '".mysqli_real_escape_string($link, $message)."' WHERE srid = '$srid'";
        $result = mysqli_query($link, $sql);
        echo "<script>";
        echo 'alert("Reply updated!");';
        echo 'window.opener.location.reload();
        window.close();';
        echo "</script>";
    }
    
}

function deleteComments($link) {
        if (isset($_POST['deleteSubmit'])) {
        $cid = $_POST['cid'];
        
        $sql = "DELETE FROM comments WHERE cid = '$cid'";
        $result = mysqli_query($link, $sql);
        $sql2 = "DELETE FROM replies WHERE cid = '$cid'";
        $result2 = mysqli_query($link, $sql2);
        $sql3 = "DELETE FROM secondReplies WHERE cid = '$cid'";
        $result3 = mysqli_query($link, $sql3);
    }
}

function deleteReplies($link) {
        if (isset($_POST['deleteRSubmit'])) {
        $rid = $_POST['rid'];
        
        $sql = "DELETE FROM replies WHERE rid = '$rid'";
        $result = mysqli_query($link, $sql);
        $sql2 = "DELETE FROM secondReplies WHERE rid = '$rid'";
        $result2 = mysqli_query($link, $sql2);
    }
}

function deleteSReplies($link) {
        if (isset($_POST['deleteSRSubmit'])) {
        $srid = $_POST['srid'];
        
        $sql = "DELETE FROM secondReplies WHERE srid = '$srid'";
        $result = mysqli_query($link, $sql);
    }
}

function replyComments($link) {
    if (isset($_POST['replySubmit'])) {
        $cid = $_POST['cid'];
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];
        
        
        $sql = "INSERT INTO replies (cid, uid, date, message) VALUES ('$cid', '$uid', '$date', '".mysqli_real_escape_string($link, $message)."')";
        $result = mysqli_query($link, $sql);
        
        echo "<script>";
        echo 'alert("Replied to a comment!");';
        echo 'window.opener.location.reload();
        window.close();';
        echo "</script>";
    }
}

function replyReplies($link) {
    if (isset($_POST['replyRSubmit'])) {
        $rid = $_POST['rid'];
        $cid = $_POST['cid'];
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];
        
        
        $sql = "INSERT INTO secondReplies (rid, cid, uid, date, message) VALUES ('$rid', '$cid', '$uid', '$date', '".mysqli_real_escape_string($link, $message)."')";
        $result = mysqli_query($link, $sql);
        
        echo "<script>";
        echo 'alert("Replied to a reply!");';
        echo 'window.opener.location.reload();
        window.close();';
        echo "</script>";
    }
}

?>

<script>
function target_popup(form) {
    window.open('', 'formpopup', 'width=800,height=400,resizeable,scrollbars');
    form.target = 'formpopup';
}
</script>