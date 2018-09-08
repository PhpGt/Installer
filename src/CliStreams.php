<?php
namespace Gt\Installer;

use SplFileObject;

class CliStreams {
	const IN = "in";
	const OUT = "out";
	const ERROR = "error";

	/** @var SplFileObject */
	protected $error;
	/** @var SplFileObject */
	protected $out;
	/** @var SplFileObject */
	protected $in;
	/** @var SplFileObject */
	protected $currentStream;

	public function __construct(string $in, string $out, string $error) {
		$this->setStreams($in, $out, $error);
	}

	public function setStreams(string $in, string $out, string $error) {
		$this->in = new SplFileObject(
			$in,
			"r"
		);
		$this->out = new SplFileObject(
			$out,
			"w"
		);
		$this->error = new SplFileObject(
			$error,
			"w"
		);
	}

	public function getInStream():SplFileObject {
		return $this->in;
	}

	public function getOutStream():SplFileObject {
		return $this->out;
	}

	public function getErrorStream():SplFileObject {
		return $this->error;
	}

	public function write(
		string $message,
		string $streamName = self::OUT
	):void {
		$this->getNamedStream($streamName)->fwrite($message);
	}

	public function writeLine(
		string $message = "",
		string $streamName = self::OUT
	):void {
		$this->write(
			$message . PHP_EOL,
			$streamName
		);
	}

	protected function getNamedStream(string $streamName):SplFileObject {
		switch($streamName) {
		case self::IN:
			return $this->in;
		case self::OUT:
			return $this->out;
		case self::ERROR:
			return $this->error;
		}
	}
}