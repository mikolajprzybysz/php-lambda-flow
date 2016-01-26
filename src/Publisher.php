<?php
namespace LambdaFlow;

/**
 * Publish message to SQS queue and trigger lambda subscribed to given sns topic.
 *
 * @package   LambdaFlow
 * @author    "Mikolaj Przybysz" <mikolaj.przybysz@gmail.com>
 * @license   MIT
 */
class Publisher implements PublisherInterface
{
    /** @var \Aws\Sqs\SqsClient $sqs */
    private $sqs;

    /** @var string $sqsQueueUrl */
    private $sqsQueueUrl;

    /** @var \Aws\Sns\SnsClient $sns */
    private $sns;

    /** @var string $snsTopicArn */
    private $snsTopicArn;

    /**
     * Dependency Injection.
     *
     * @param \Aws\Sqs\SqsClient $sqs         client api
     * @param string             $sqsQueueUrl to send the message to
     * @param \Aws\Sns\SnsClient $sns         client api
     * @param string             $snsTopicArn to trigger lambda subscribers to this topic
     */
    public function __construct(
        $sqs,
        $sqsQueueUrl,
        $sns,
        $snsTopicArn
    ) {
        $this->sqs         = $sqs;
        $this->sqsQueueUrl = $sqsQueueUrl;
        $this->sns         = $sns;
        $this->snsTopicArn = $snsTopicArn;
    }

    /**
     * Send message to sqs and trigger lambda
     *
     * @param string $message to be send via sqs
     *
     */
    public function publish($message) {

        // http://docs.aws.amazon.com/aws-sdk-php/v2/api/class-Aws.Sqs.SqsClient.html#_sendMessage
        $this->sqs->sendMessage([
            'QueueUrl' => $this->sqsQueueUrl,
            'MessageBody' => $message
        ]);

        // http://docs.aws.amazon.com/aws-sdk-php/v2/api/class-Aws.Sns.SnsClient.html#_publish
        $this->sns->publish([
            'TopicArn' => $this->snsTopicArn,
            // Message is required
            'Message' => 'SQS Message send',
            'Subject' => 'SQS Message send',
        ]);

    }
}
