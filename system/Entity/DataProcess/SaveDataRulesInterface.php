<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataProcess {

	interface SaveDataRulesInterface {
		public function assertMethodExists(string $method, string $addMessage = '', $obj = NULL);

		public function maxLength(SaveDataManagerInterface $dataManager);

		public function minLength(SaveDataManagerInterface $dataManager);

		public function eqLength(SaveDataManagerInterface $dataManager);

		public function serialize(SaveDataManagerInterface $dataManager);

		public function now(SaveDataManagerInterface $dataManager);

		public function delete(SaveDataManagerInterface $dataManager);

		public function required(SaveDataManagerInterface $dataManager);

		public function assertUniqueExists(SaveDataManagerInterface $dataManager);

		public function assertNotExists(SaveDataManagerInterface $dataManager);

		public function assertExists(SaveDataManagerInterface $dataManager);
	}
}