<a href="#" id="show_menu">&raquo;</a>
<div id="left_menu">
	<ul id="main_menu">
		<li id="hide_menu"><a href="#">&laquo;</a></li>
		<li>
			<?php echo $this->Html->link($this->Html->image('icon_pages.png', array('alt'=>'Pages')) . ' Pages', $this->Html->url('/admin/pages/'), array('escape' => false)); ?>
			<ul>
			</ul>
		</li>
		<li>
			<?php echo $this->Html->link($this->Html->image('icon_users.png', array('alt'=>'Users')) . ' Users', $this->Html->url('/admin/users/'), array('escape' => false)); ?>
			<ul>
				<li><?php echo $this->Html->link('Employees', array('controller' => 'employees', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Recruiters', array('controller' => 'recruiters', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Reps', array('controller' => 'reps', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('People', array('controller' => 'people', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Volunteers', array('controller' => 'volunteers', 'action' => 'index'))?></li>
			</ul>	
		</li>
		<li>
			<a href="#"><?php echo $this->Html->image('icon_posts.png', array('alt'=>'Posts')); ?>Catalog Data</a>
			<ul>
				<li><?php echo $this->Html->link('Addons', array('controller' => 'addons', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Departure Dates', array('controller' => 'departure_dates', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Destinations', array('controller' => 'destinations', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Locales', array('controller' => 'locales', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Prices', array('controller' => 'prices', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Programs', array('controller' => 'programs', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Project Categories', array('controller' => 'project_categories', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Tours', array('controller' => 'tours', 'action' => 'index'))?></li>
			</ul>	
		</li>
		<li><a href="#"><?php echo $this->Html->image('icon_home.png', array('alt'=>'Home')); ?>System Data</a>
			<ul>
				<li><?php echo $this->Html->link('Gallery Categories', array('controller' => 'gallery_categories', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Note Categories', array('controller' => 'note_categories', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Note Types', array('controller' => 'note_types', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Offices', array('controller' => 'offices', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Payment Methods', array('controller' => 'payment_methods', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Payment Types', array('controller' => 'payment_types', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Referral Types', array('controller' => 'referral_types', 'action' => 'index'))?></li>
				<li><?php echo $this->Html->link('Schools', array('controller' => 'schools', 'action' => 'index'))?></li>
			</ul>
		</li>
	</ul>	
</div>