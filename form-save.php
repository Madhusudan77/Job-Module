<?php 
$postTitle = $_POST['name'];
$post = $_POST['post'];
$submit = $_POST['submit'];

if(isset($submit)){

    global $user_ID;

    $new_post = array(
        'post_title' => $postTitle,
        'post_content' => $post,
        'post_status' => 'publish',
        'post_date' => date('Y-m-d H:i:s'),
        'post_author' => $user_ID,
        'post_type' => 'jobs',
        'post_category' => array(0)
    );

    wp_insert_post($new_post);

}

?>

<div id="wrap">
<form action="" method="post">
<table border="1" width="200">
  <tr>
    <td><label for="post_title">Post Title</label></td>
    <td><input name="post_title" type="text" /></td>
  </tr>
  <tr>
    <td><label for="post">Post</label></td>
    <td><input name="post" type="text" /></td>
  </tr>
</table>

<input name="submit" type="submit" value="submit" />
</form>
</div>
