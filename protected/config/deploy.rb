# for more information look at help.github.com/capistrano/
set :application, "weblogic/Barcode"
server "192.168.122.226", :web # your server address or IP
set :user, "webdev" # your username for ssh
set :use_sudo, false

# set the remote directory you're going to deploy to
set :deploy_to, "/home/#{user}/www/#{application}"

# disable rails specific normalize_assets property
set :normalize_asset_timestamps, false

# use local repository and copy via :scp instead of clone.
# change this in case you have a url repository
set :via, :scp
set :scm, "git"
set :repository, "."
set :deploy_via, :copy
set :branch, "master"
set :gateway, "webdev@barcode.finservice.pro"

# Exclude some files
set :copy_exclude, [".git", ".gitignore", "protected/config/db.php"]

# Set here the files which should stay the same between releases
set :shared_children, %w(assets protected/runtime vendor userfiles)

namespace :deploy do
  # Override default rails migrations in case you use them
  #task :migrate do
  #  run "#{latest_release}/yii migrate --interactive=0"
  #end

  # If you use migrations and don't want to run `cap deploy:migrations` every time
  # uncomment following 3 lines
  #task :default do
  #  migrations
  #end

  # Install composer dependencies (replace `cd` with something smarter if you wish)
  task :composer do
    run "cd #{latest_release} && php composer.phar install"
    run "protected/yiic migrate"
  end

  # Make shared_children directories writable by others in case web server isn't in your group
  # By default capistrano sets 0775 mode for those directories
  task :after_setup do
    dirs = shared_children.map { |d| File.join(shared_path, d.split('/').last) }
    run "#{try_sudo} chmod o+w #{dirs.join(' ')}"
  end
end

after "deploy:setup", "deploy:after_setup"
after "deploy:finalize_update", "deploy:composer"
