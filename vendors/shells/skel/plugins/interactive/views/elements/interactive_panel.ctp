<?php
  echo $form->create('Interactive', array('url' => array('admin' => false, 'plugin' => 'interactive', 'controller' => 'interactive', 'action' => 'cmd'), 'id' => 'interactive-form'));
  echo $form->input('cmd', array('type' => 'textarea', 'label' => false, 'cols' => '100'));
	echo $html->image('/interactive/img/ajax-loader.gif', array('id' => 'interactive-indicator'));
  echo $form->end('Execute');
?>
<br />
<div id="interactive-results"></div>

<script type="text/javascript">
	DEBUGKIT.module('interactivePanel');
	DEBUGKIT.interactivePanel = function () {
		var Event = DEBUGKIT.Util.Event,
				Request = DEBUGKIT.Util.Request,
				Element = DEBUGKIT.Util.Element,
				Toolbar = DEBUGKIT.toolbar,
				results = document.getElementById('interactive-results');
				indicator = document.getElementById('interactive-indicator');
			
		var showResults = function (response) {
			Element.hide(indicator);
			results.innerHTML = response.response.text;
			if (document.getElementsByClassName) {
				lists = results.getElementsByClassName('depth-0');
			} else {
				lists = results.getElementsByTagName('ul');
			}

			Toolbar.makeNeatArray(lists);
		};
		
		function interactivePanelExectute (event) {
			Element.show(indicator);
			event.preventDefault();
			
			var remote = new Request({
				method : 'POST',
				headers : {
					'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
					'X-Requested-With': 'XMLHttpRequest',
					'Accept': 'text/javascript, text/html, application/xml, text/xml, */*'
				},
				onComplete : showResults,
				onFail : function () {
					Element.hide(indicator);
					results.innerHTML = "";
					alert('Intereactive session failed');
				}
			});
			
			remote.send(this.action, "data[Interactive][cmd]="
                  + encodeURIComponent(document.getElementById("InteractiveCmd").value));
		};
		
		return {
			init : function () {
				Element.hide(indicator);
				Event.addEvent(document.getElementById("interactive-form"), 'submit', interactivePanelExectute);
			}
		};
	}();
		
	DEBUGKIT.loader.register(DEBUGKIT.interactivePanel);
</script>