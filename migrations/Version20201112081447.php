<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201112081447 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE day_user (day_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_26FB3B3F9C24126 (day_id), INDEX IDX_26FB3B3FA76ED395 (user_id), PRIMARY KEY(day_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE day_user ADD CONSTRAINT FK_26FB3B3F9C24126 FOREIGN KEY (day_id) REFERENCES day (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE day_user ADD CONSTRAINT FK_26FB3B3FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE day_user');
    }
}
