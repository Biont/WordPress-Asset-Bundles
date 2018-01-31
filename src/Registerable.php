<?php # -*- coding: utf-8 -*-

namespace Biont\AssetBundles;

interface Registerable
{

    public function register(): bool;

    public function isRegistered(): bool;
}
