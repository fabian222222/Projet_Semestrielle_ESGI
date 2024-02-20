<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215231357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE driving_school ADD number INT NULL');
        $this->addSql('ALTER TABLE driving_school ADD city VARCHAR(255) NULL');
        $this->addSql('ALTER TABLE driving_school ADD zip_code INT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE driving_school DROP number');
        $this->addSql('ALTER TABLE driving_school DROP city');
        $this->addSql('ALTER TABLE driving_school DROP zip_code');
    }
}
