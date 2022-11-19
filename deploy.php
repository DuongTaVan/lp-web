<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'vendor/deployer/recipes/recipe/slack.php';

// Project name
set('application', 'lappi-web');

// Project repository
set('repository', 'https://github.com/skrum-inc/lappi-web');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// The number of keeping releases.
set('keep_releases', 3);

// Shared files/dirs between deploys 
add('shared_files', ['.env']);
add('shared_dirs', ['storage']);

// Writable dirs by web server 
add('writable_dirs', ['bootstrap/cache', 'storage']);

// Allow sending anonymous usage statistics
set('allow_anonymous_stats', false);


// Hosts
inventory('hosts.yml');


// Tasks

// Confirm whether deploy information is correct.
task('confirm', function() {
    $stage = input()->getArgument('stage');
    $branch = input()->getOption('branch');

    if ($branch == "") {
        $branch = get('branch');
    }

    if (! askConfirmation("Do you deploy " . $branch . " to " . $stage . " ?", true)){
        writeln("<info>Will suspend deploy.</info>");
        die();
    }
})->desc('Confirm whether deploy information is correct.');

before('deploy:prepare', 'confirm');

// Build
task('build', function () {
    run('cd {{release_path}} && build');
});

task('artisan:optimize', function () {});

// Regarding npm
set('bin/npm', function () {
    return run('which npm');
});
desc('Install npm packages');
task('npm:install', function () {
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/node_modules ]')) {
            run('cp -R {{previous_release}}/node_modules {{release_path}}');
        }
    }
    run("cd {{release_path}} && {{bin/npm}} install && {{bin/npm}} run prod");
});
after('deploy:update_code', 'npm:install');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Overwrite shared/.env with .env.{stage}
// We mustn't use Git to manage things like AWS secret key. Therefore, the following code should basically be commented out.
// after('deploy:shared', 'overwrite-env');
// task('overwrite-env', function () {
//     $stage = get('stage');
//     $src = ".env.${stage}";
//     $deployPath = get('deploy_path');
//     $sharedPath = "${deployPath}/shared";
//     run("cp -f {{release_path}}/${src} ${sharedPath}/.env");
// });

// Migrate database before symlink new release.
// before('deploy:symlink', 'artisan:migrate');

// Notify to Slack.
set('slack_webhook', 'https://hooks.slack.com/services/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');
set('slack_success_text', 'Deploy `{{branch}}` to *{{target}}* successful');
set('slack_failure_text', 'Deploy `{{branch}}` to *{{target}}* failed');
after('success', 'slack:notify:success');
after('deploy:failed', 'slack:notify:failure');
