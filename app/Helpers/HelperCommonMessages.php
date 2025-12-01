<?php

if (!function_exists('NotFoundMessage'))
{
    function NotFoundMessage()
    {
        return "No Records Found !";
    }
}

if (!function_exists('PermissionDenied'))
{
    function PermissionDenied()
    {
        return "permission_denied";
    }
}

if (!function_exists('ErrorOccuredMessage'))
{
    function ErrorOccuredMessage()
    {
        return "Oops! Something Went Wrong.";
    }
}

if (!function_exists('ErrorAlreadyExistMessage'))
{
    function ErrorAlreadyExistMessage()
    {
        return "Same value already exist , please try again.!";
    }
}

if (!function_exists('DataRemovalMessage'))
{
    function DataRemovalMessage()
    {
        return "Patient Health Record Deleted Successfully!";
    }
}

if (!function_exists('DataAddedMessage'))
{
    function DataAddedMessage()
    {
        return "Patient Health Record Added Successfully!";
    }
}

if (!function_exists('DataUpdatedMessage'))
{
    function DataUpdatedMessage()
    {
        return "Patient Health Record Updated Successfully!";
    }
}

if (!function_exists('ActionRestrcited'))
{
    function ActionRestrcited()
    {
        return "Sorry Action Restricted!";
    }
}



if (!function_exists('SystemDataRemovalMessage'))
{
    function SystemDataRemovalMessage()
    {
        return "System Record Deleted Successfully!";
    }
}

if (!function_exists('SystemDataAddedMessage'))
{
    function SystemDataAddedMessage()
    {
        return "System Record Added Successfully!";
    }
}

if (!function_exists('SystemDataUpdatedMessage'))
{
    function SystemDataUpdatedMessage()
    {
        return "System Record Updated Successfully!";
    }
}

?>
