<small>edit me in <code>APP/View/Elements/layout/footer.ctp</code></small>
			<?php
				echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework'), 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				), 
				$this->Html->link(
					$this->Html->image('h5bp.gif', array('alt'=> __('Html5 Boilerplate'), 'border' => '0')),
					'http://www.html5boierlplate.com/',
					array('target' => '_blank', 'escape' => false)
				);
			?>