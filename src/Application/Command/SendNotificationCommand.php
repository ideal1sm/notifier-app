<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Notification\Message\EmailNotification;
use App\Domain\Notification\Message\NotificationInterface;
use App\Domain\Notification\Message\PushNotification;
use App\Domain\Notification\Message\SmsNotification;
use App\Domain\Notification\Service\NotificationSender;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

#[AsCommand(name: 'producer:send')]
class SendNotificationCommand extends Command
{
    public function __construct(private readonly NotificationSender $sender)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('type', InputArgument::REQUIRED, 'Тип уведомления: email, sms, push')
            ->addArgument('content', InputArgument::REQUIRED, 'Текст уведомления')
            ->addArgument('subject', InputArgument::OPTIONAL, 'Тема для email');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $type = $input->getArgument('type');
        $content = $input->getArgument('content');
        $subject = $input->getArgument('subject');

        $notification = $this->createNotification($type, $content, $subject);

        $this->sender->send($notification);

        $output->writeln(sprintf('Notification dispatched: [%s] %s', $type, $content));

        return Command::SUCCESS;
    }

    private function createNotification(string $type, string $content, ?string $subject): NotificationInterface
    {
        return match ($type) {
            'email' => new EmailNotification($subject ?? 'No Subject', $content),
            'sms' => new SmsNotification($content),
            'push' => new PushNotification($content),
            default => throw new \InvalidArgumentException("Unknown notification type: $type"),
        };
    }
}