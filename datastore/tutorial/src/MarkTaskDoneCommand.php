<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Samples\Datastore\Tasks;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MarkTaskDoneCommand
 * @package Google\Cloud\Samples\Datastore\Tasks
 *
 * Mark a task with a given id as done.
 */
class MarkTaskDoneCommand extends Command
{
    protected function configure()
    {
        $this->setName('done')
            ->setDescription('Mark a task as done')
            ->addArgument(
                'taskId',
                InputArgument::REQUIRED,
                'The id of the task to mark as done'
            )
            ->addOption(
                'project-id',
                null,
                InputOption::VALUE_OPTIONAL,
                'Your cloud project id'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectId = $input->getOption('project-id');
        if (!empty($projectId)) {
            $datastore = build_datastore_service($projectId);
        } else {
            $datastore = build_datastore_service_with_namespace();
        }
        $taskId = intval($input->getArgument('taskId'));
        mark_done($datastore, $taskId);
        $output->writeln(sprintf('Task %d updated successfully.', $taskId));
    }
}
