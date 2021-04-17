@php
    $title = "Dashboard";
    $breadcrumbs[] = ["label" => "Home", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])
