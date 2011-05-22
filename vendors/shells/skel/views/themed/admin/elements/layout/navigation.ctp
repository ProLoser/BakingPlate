<header>
	<hgroup>
		<h1><?php echo $this->Html->link('Administrator', '/admin')?></h1>
		<h2><?php echo $this->Html->link('View Site', '/')?></h2>
	</hgroup>
	<div>
		<p>John Doe (<a href="#">3 Messages</a>) </p>
		<?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'), array('title' => 'Logout', 'class' => 'logout'))?>
	</div>
</header> 

<form class="quick_search">
	<input type="text" value="Quick Search" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;">
</form>
<hr/>
<h3>Content</h3>
<ul class="toggle">
	<li class="icn_new_article"><a href="#">New Article</a></li>
	<li class="icn_edit_article"><a href="#">Edit Articles</a></li>
	<li class="icn_categories"><a href="#">Categories</a></li>
	<li class="icn_tags"><a href="#">Tags</a></li>
</ul>
<h3>Users</h3>
<ul class="toggle">
	<li class="icn_add_user"><a href="#">Add New User</a></li>
	<li class="icn_view_users"><a href="#">View Users</a></li>
	<li class="icn_profile"><a href="#">Your Profile</a></li>
</ul>
<h3>Media</h3>
<ul class="toggle">
	<li class="icn_folder"><a href="#">File Manager</a></li>
	<li class="icn_photo"><a href="#">Gallery</a></li>
	<li class="icn_audio"><a href="#">Audio</a></li>
	<li class="icn_video"><a href="#">Video</a></li>
</ul>
<h3>Admin</h3>
<ul class="toggle">
	<li class="icn_settings"><a href="#">Options</a></li>
	<li class="icn_security"><a href="#">Security</a></li>
	<li class="icn_jump_back"><a href="#">Logout</a></li>
</ul>

<footer>
	<hr />
	<p><strong>Copyright &copy; 2011 Website Admin</strong></p>
	<p>Theme by <a href="http://www.medialoot.com">MediaLoot</a></p>
</footer>