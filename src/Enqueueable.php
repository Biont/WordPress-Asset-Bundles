<?php # -*- coding: utf-8 -*-

namespace Biont\AssetBundles;

interface Enqueueable extends Registerable
{

    public function enqueue(): bool;

    public function isEnqueued(): bool;
}
