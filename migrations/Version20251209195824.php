<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251209195824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create notification_types and notifications tables with FK and seed types';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE notification_types (
            id SERIAL PRIMARY KEY,
            name VARCHAR(50) NOT NULL UNIQUE
        )');

        $this->addSql("INSERT INTO notification_types (name) VALUES ('email'), ('sms'), ('push')");

        $this->addSql('CREATE TABLE notifications (
            id SERIAL PRIMARY KEY,
            type_id INT NOT NULL,
            recipient VARCHAR(255) NOT NULL,
            subject VARCHAR(255),
            content TEXT NOT NULL,
            status VARCHAR(20) NOT NULL,
            created_at TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
            CONSTRAINT FK_notifications_type FOREIGN KEY (type_id) REFERENCES notification_types(id) ON DELETE RESTRICT
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS notifications');
        $this->addSql('DROP TABLE IF EXISTS notification_types');
    }
}
