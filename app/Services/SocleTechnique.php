<?php

namespace App\Services;

use Beta\Microsoft\Graph\Model\Storage;
use Illuminate\Console\OutputStyle;

class SocleTechnique
{

    public function __construct(private Utils $utils)
    {

    }

    /**
     * The output interface implementation.
     *
     * @var \Illuminate\Console\OutputStyle
     */
    private $output;

    /**
     * Set the output interface implementation.
     *
     * @param \Illuminate\Console\OutputStyle $output
     * @return void
     */
    public function setOutput(OutputStyle $output)
    {
        $this->output = $output;
    }

    public function createWindowsPackage()
    {
        [$socle_dir, $global_dir] = $this->utils->getPackageDirs('windows');
        $packages = config('packageWindows');
        $this->output->info("Get Links from config file");
        $vals = [];
        foreach ($packages as $k => $v) {
            $vals[] = [$k, $v];
        }
        $this->output->table(['Name', 'Link'], $vals);
        $this->output->info("Download socle technique package from net");
        $files_path = [];
        foreach ($packages as $name => $url) {
            $base_name = basename($url);
            $this->output->info("Treatment of package $name");
            $file = $socle_dir . DIRECTORY_SEPARATOR . $base_name;
            $files_path[$name] = $file;
            if (file_exists($file)) {
                $this->output->info("Package $name with Url $url exit and not Downloaded");
                continue;
            }
            if ($this->utils->downloadFile($url, $socle_dir)) {
                $this->output->success("Download $url done successfully and saved to $socle_dir");
            } else {
                $this->output->error("Error download $url");
            }
        }
        // copy socle technique
        $socle_dir = $global_dir . '/Socle';
        Storage::makeDirectory($socle_dir);
        foreach ($files_path as $type => $file) {
            $base_name = basename($file);
            $dist_file = $socle_dir . '/' . $base_name;
            if ($type == 'php') {
                $php = $global_dir . '/Socle/PHP';
                Storage::makeDirectory($php);
                $dist_file = $php . '/' . $base_name;
            }
            Storage::copy($file, $dist_file);
        }
    }

    public function createLinuxPackage()
    {
        // download php
        [$socle_dir, $global_dir] = $this->utils->getPackageDirs('linux');
        $packages = config('packageLinux');
        $this->output->info("Get rpm from config file");
        $vals = [];
        foreach ($packages as $k => $v) {
            $vals[] = [$k, $v];
        }
        $this->output->table(['Name', 'Link'], $vals);
        $packageFiles = collect([]);
        $this->output->info("Download rpms");
        foreach ($packages as $name => $urls) {
            $dir = $socle_dir . '/' . $name;
            Storage::makeDirectory($dir);
            if (is_array($urls)) {
                $urls = implode(' ', $urls);
            }
            $cmd = "cd $dir && cd .. && dnf download --nogpgcheck --resolve $urls --downloadonly --downloaddir $dir";
            exec($cmd,$out,$res);
            if($res > 0) {
                $this->output->error("Error download package rpm $urls");
            } else {
                $this->output->success("Download package rpm $urls done successfully");
            }
            $packageFiles->mergeRecursive([$name,glob($dir,GLOB_BRACE)]);
        }

        $this->output->info("Copy rpms to $global_dir");
        $packageFiles->each(function (string $item, array $files) use ($global_dir) {
            $new_dir = $global_dir . '/' . $item;
            if (($item == 'php') or ($item == 'powershell')) {
                Storage::makeDirectory($new_dir);
                $this->output->info("Copy $item rpms to $new_dir");
            } else {
                $new_dir = $global_dir;
            }
            foreach ($files as $file) {
                $dest = $new_dir . '/' . basename($file);
                Storage::copy($file, $dest);
            }
        });

    }

}
