<?php
namespace LambdaFlow;

/**
 * Publish message to SQS queue and trigger lambda subscribed to given sns topic.
 *
 * @package   LambdaFlow
 * @author    "Mikolaj Przybysz" <mikolaj.przybysz@gmail.com>
 * @license   MIT
 */
interface PublisherInterface
{

    /**
     * Send message to sqs and trigger lambda
     *
     * @param string $message to be send via sqs
     *
     */
    public function publish($message);
}
