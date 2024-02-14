<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240211152441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD firstname VARCHAR(255) NULL');
        $this->addSql('ALTER TABLE client DROP name');
        $this->addSql('ALTER TABLE client DROP address');
        $this->addSql('ALTER TABLE client DROP city');
        $this->addSql('ALTER TABLE client DROP zip_code');
        $this->addSql('ALTER TABLE client DROP number');
        $this->addSql('ALTER TABLE client DROP phone_number');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN name TO lastname');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE client ADD address VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client ADD city VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client ADD zip_code INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD number INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD phone_number VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client RENAME COLUMN firstname TO name');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN lastname TO name');
    }
}
