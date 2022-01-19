<?php


if(!function_exists('flash_message'))
{
    /**
     * Global function to initialize a sweet notification from backend
     *
     * @param $notificationTitle
     * @param $notificationMessage
     * @param $notificationType
     * @param $notificationTextButton
     */
    function notification_flash($notificationTitle, $notificationMessage, $notificationType, $notificationTextButton)
    {
        session()->flash('notification.title', $notificationTitle);
        session()->flash('notification.message', $notificationMessage);
        session()->flash('notification.type', $notificationType);
        session()->flash('notification.textButton', $notificationTextButton);
    }
}

if(!function_exists('info_flash'))
{
    /**
     * Shortcut to display an info notification from backend
     *
     * @param $message
     * @param string $buttonText
     */
    function info_flash($message, $buttonText = 'OK')
    {
        notification_flash('Info', $message, 'info', $buttonText);
    }
}

if(!function_exists('success_flash'))
{
    /**
     * Shortcut to display an success notification from backend
     *
     * @param $message
     * @param string $buttonText
     */
    function success_flash($message, $buttonText = 'OK')
    {
        notification_flash('Success', $message, 'success', $buttonText);
    }
}

if(!function_exists('warning_flash'))
{
    /**
     * Shortcut to display an warning notification from backend
     *
     * @param $message
     * @param string $buttonText
     */
    function warning_flash($message, $buttonText = 'OK')
    {
        notification_flash('Warning', $message, 'warning', $buttonText);
    }
}

if(!function_exists('danger_flash'))
{
    /**
     * Shortcut to display an danger notification from backend
     *
     * @param $message
     * @param string $buttonText
     */
    function danger_flash($message, $buttonText = 'OK')
    {
        notification_flash('Danger', $message, 'error', $buttonText);
    }
}