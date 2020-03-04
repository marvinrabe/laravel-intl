<?php

use Carbon\Carbon;
use Punic\Calendar;

Carbon::macro('toShortDateString', function() {
    return Calendar::formatDate($this, 'short');
});

Carbon::macro('toMediumDateString', function() {
    return Calendar::formatDate($this, 'medium');
});

Carbon::macro('toLongDateString', function() {
    return Calendar::formatDate($this, 'long');
});

Carbon::macro('toFullDateString', function() {
    return Calendar::formatDate($this, 'full');
});

Carbon::macro('toShortTimeString', function() {
    return Calendar::formatTime($this, 'short');
});

Carbon::macro('toMediumTimeString', function() {
    return Calendar::formatTime($this, 'medium');
});

Carbon::macro('toLongTimeString', function() {
    return Calendar::formatTime($this, 'long');
});

Carbon::macro('toFullTimeString', function() {
    return Calendar::formatTime($this, 'full');
});

Carbon::macro('toShortDatetimeString', function() {
    return Calendar::formatDatetime($this, 'short');
});

Carbon::macro('toMediumDatetimeString', function() {
    return Calendar::formatDatetime($this, 'medium');
});

Carbon::macro('toLongDatetimeString', function() {
    return Calendar::formatDatetime($this, 'long');
});

Carbon::macro('toFullDatetimeString', function() {
    return Calendar::formatDatetime($this, 'full');
});