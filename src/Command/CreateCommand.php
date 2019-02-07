<?php
namespace Gt\Installer\Command;

use Gt\Cli\Argument\ArgumentValueList;
use Gt\Cli\Command\Command;
use Gt\Cli\Stream;

class CreateCommand extends Command {
	public function __construct() {
		$this->setName("create");
		$this->setDescription(
			"Create a new WebEngine application"
		);

		$this->setRequiredNamedParameter("name");
		$this->setOptionalParameter(
			true,
			"blueprint",
			"b",
			"BLUEPRINT_NAME"
		);
	}

	public function run(ArgumentValueList $arguments = null):void {
		$cwd = getcwd();
		$appDir = implode(DIRECTORY_SEPARATOR, [
			$cwd,
			$arguments->get("name"),
		]);

		if(is_dir($appDir)) {
			$this->writeLine(
				"Directory already exists",
				Stream::ERROR
			);
		}

		$blueprint = $arguments->get("blueprint", "empty");
		$this->writeLine(
			"Creating new application in: $appDir"
		);
		$this->writeLine(
			"Using blueprint: $blueprint"
		);
		exec("composer create-project --remove-vcs webengine-blueprints/$blueprint:dev-master $appDir");
// TODO: Future release of php.gt/config:
// Use config-generate to set the correct namespace.
// Update project's composer.json to autoload the correct application classes (from namespace).
	}
}