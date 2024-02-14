<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240208131050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD address VARCHAR(255) NULL');
        $this->addSql('ALTER TABLE client ADD city VARCHAR(255) NULL');
        $this->addSql('ALTER TABLE client ADD zip_code INT NULL');
        $this->addSql('ALTER TABLE client ADD number INT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE client DROP address');
        $this->addSql('ALTER TABLE client DROP city');
        $this->addSql('ALTER TABLE client DROP zip_code');
        $this->addSql('ALTER TABLE client DROP number');
    }
}
