<?php

namespace LifeOrganizer\Core;

interface AggregateChangedEvent
{
    public function getAggregateClass(): string;
    public function aggregateId(): string;
}
