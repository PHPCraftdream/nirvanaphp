<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use League\Event\Emitter;
	use League\Event\EmitterInterface;

	trait EventsSystem {
		protected $eventsSystem;

		public function getEventsSystem(): EmitterInterface {
			if (empty($this->eventsSystem)) {
				$this->eventsSystem = new Emitter();
			}

			return $this->eventsSystem;
		}
	}
}