<?php

namespace PHPCraftdream\NirvanaPHP\Session {

	use Aura\SqlQuery\Common\InsertInterface;
	use Aura\SqlQuery\Common\SelectInterface;
	use PHPCraftdream\FigCookies\CookiesInterface;
	use PHPCraftdream\NirvanaPHP\Entity\EntityHubInterface;
	use PHPCraftdream\NirvanaPHP\Framework\FrameworkInterface;

	class SessionManager
		implements SessionManagerInterface {

		protected $sessionId;
		protected $hub;
		protected $cookies;

		public function __construct(EntityHubInterface $hub, CookiesInterface $cookies) {
			$this->hub = $hub;
			$this->cookies = $cookies;
		}

		public function getEntityHub(): EntityHubInterface {
			return $this->hub;
		}

		public function getCookies(): CookiesInterface {
			return $this->cookies;
		}

		//----------------------------------------------------------------

		public function start() {
			$this->touchCookieSessionId();
		}

		public function getSessionKeyName() {
			return 'sessionName';
		}

		public function getSessionId(): string {
			if (!empty($this->sessionId)) {
				return $this->sessionId;
			}

			$this->sessionId = $this->touchCookieSessionId();

			return $this->sessionId;
		}

		//----------------------------------------------------------------

		protected function touchSession(string $sessionId): int {
			$entityHub = $this->getEntityHub();
			$sessionEntity = $entityHub->get('session');

			$where = function (SelectInterface $select) use ($sessionId) {
				/** @noinspection PhpMethodParametersCountMismatchInspection */
				$select->where('sessionId = ?', $sessionId);
				$select->limit(1);
			};

			$sessionRes = $sessionEntity->readOne($where);

			if (!$sessionRes->exists()) {
				$result = $sessionEntity->create(['sessionId' => $sessionId]);
				$sessionRes = $sessionEntity->readOne($where);
			}

			if (!$sessionRes->exists()) {
				throw new SessionException('wtf? #1');
			}

			$sessionData = $sessionRes->obj();
			$sessionTableId = $sessionData->get('id');

			return intval($sessionTableId);
		}

		public function setValue(string $name, $value) {
			$entityHub = $this->getEntityHub();
			$sessionId = $this->getSessionId();

			$sessionTableId = $this->touchSession($sessionId);

			$sessionEntity = $entityHub->get('sessionData');

			$res = $sessionEntity->create(
				['tSession' => $sessionTableId, 'pName' => $name, 'pData' => $value],
				function (InsertInterface $insert) use ($name, $value) {
					/** @noinspection PhpUndefinedMethodInspection */
					$insert->onDuplicateKeyUpdateCols(['pData' => serialize($value)]);
				}
			);

			if ($res->hasError()) {
				throw new SessionException('wtf? #2');
			}
		}

		//----------------------------------------------------------------

		protected function touchCookieSessionId(): string {
			$name = $this->getSessionKeyName();
			$cookie = $this->getCookies()->get($name);
			$sessionId = $cookie->getValue();

			if (!$sessionId) {
				$sessionId = bin2hex(random_bytes(16));
				$cookie->setValue($sessionId);
				$cookie->setPath('/')->setHttpOnly(true);
			}

			return $sessionId;
		}
	}
}
