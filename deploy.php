<?php
namespace Deployer;

require 'recipe/symfony3.php';

// Project name
set('application', 'wiki_game');

// Project repository
set('repository', 'git@github.com:rdbn/easygamesinc.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', ['app/config/parameters.yml']);
add('shared_dirs', ['var/log', 'vendor']);

// Writable dirs by web server
set('writable_dirs', []);

// Hosts
host('88.198.150.59')
    ->stage('production')
    ->user('easygamesinc')
    ->set('deploy_path', '/var/www/wiki_game')
    ->set('branch', 'master')
    ->set('clear_path', []);

// Tasks
task('build', function () {
    run('cd {{release_path}} && build');
});

desc('Reload PHP-FPM service');
task('php-fpm:reload', function () {
    run('sudo /etc/init.d/php7.2-fpm reload');
});

desc('Reload Nginx service');
task('nginx:reload', function () {
    run('sudo /etc/init.d/nginx reload');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:symlink', 'php-fpm:reload');
after('php-fpm:reload', 'nginx:reload');
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');

