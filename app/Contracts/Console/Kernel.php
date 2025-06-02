<?php
namespace BananaPHP\Contracts\Console;

interface Kernel
{
    public function handle(): int;
}