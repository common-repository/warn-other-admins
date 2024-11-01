<?php
/*
Plugin Name: Warn Other Admins
Plugin URI: http://erayalakese.com/project/warn-other-admins/
Description: With this plugin you can warn other wp-admin users. For example, you can type "<strong>Don't touch widgets! I'll fix it tomorrow !</strong>" :) 
Author: Eray Alakese
Version: 0.1
Author URI: http://erayalakese.com
*/

function showMessage($m)
{
	echo '<div id="message" class="error">';
	echo "<p><strong>$m</strong></p></div>";
} 

function showAdminMessages()
{
	$m = get_option("woa-message");
    showMessage(stripslashes($m));
}
if(get_option("woa-message") != NULL)
add_action('admin_notices', 'showAdminMessages');

add_action("admin_menu", "woa_adminpage_hook");
function woa_adminpage_hook()
{
	add_options_page("Warn Other Admins", "Warn Other Admins", "manage_options", "woa", "woa_adminpage_inner");
}
function woa_adminpage_inner()
{
	if(isset($_POST["woa-message"]))
	{
		update_option("woa-message", $_POST["woa-message"]);
		if($_POST["woa-message"] != "")
			$added = TRUE;
		else
			$removed = TRUE;
	}
	?>
	<div class="wrap">
		<h1>Warn Other Admins</h1><hr />
		<?php if($added == TRUE) echo "<div id='message' class='updated'><p>Warning added ! Now you can <a href='{$_SERVER['REQUEST_URI']}'>refresh</a> page.</p></div>"; elseif($removed == TRUE) echo "<div id='message' class='updated'><p>Warning removed ! Now you can <a href='{$_SERVER['REQUEST_URI']}'>refresh</a> page.</p></div>"; ?>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" style="text-align:center">
			<textarea name="woa-message" style="width:75%;font-weight:bold;font-size:16px"><?php echo stripslashes(get_option("woa-message")); ?></textarea><br />
			<input type="submit" class="button-primary" value="WARN !" />
		</form>
	</div>
	<hr />
	<span style="display:block;float:right;color:font-family: Georgia, serif;font-size: 10px;font-style: normal;font-weight: bold;text-transform: uppercase;letter-spacing: 1px;line-height: 2em;margin-right:30px">
		Developer : <a href="http://www.erayalakese.com" style="text-decoration:none">Eray Alakese</a> <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.erayalakese.com&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=142492109193732" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
	</span>
	<?php
}