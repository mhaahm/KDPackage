echo Package deploy...
echo clearing cache...

:; if [ -z 0 ]; then
  @echo off
  goto :WINDOWS
fi


if [ ! -z $1 ]
then
    env=$1
else
    env=prod
fi
echo "Install KDPackage"
php artisan app:install




:WINDOWS
SET env=%1
IF "%env%"=="" SET env=prod
echo "Install KDPackage"
php artisan app:install
