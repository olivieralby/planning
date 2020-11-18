<?php
use Rewieer\TaskSchedulerBundle\Task\AbstractScheduledTask;
use Rewieer\TaskSchedulerBundle\Task\Schedule;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class  Task  extends  AbstractScheduledTask {

  private $mailer;

  public function __construct(MailerInterface $mailer)
  {
    $this->mailer = $mailer;
  }
    protected function initialize(Schedule $schedule) {
        $schedule
          ->everyMinutes(5); // Perform the task every 5 minutes
      } 

  public  function  run () {
     $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Remplir votre planning')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
  }
}