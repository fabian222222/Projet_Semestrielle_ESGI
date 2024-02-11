<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240209141012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ALTER address SET NOT NULL');
        $this->addSql('ALTER TABLE client ALTER city SET NOT NULL');
        $this->addSql('ALTER TABLE client ALTER zip_code SET NOT NULL');
        $this->addSql('ALTER TABLE client ALTER number SET NOT NULL');
        $this->addSql('ALTER TABLE client ALTER phone_number SET NOT NULL');
        $this->addSql('ALTER TABLE driving_school DROP logo_name');
        $this->addSql('ALTER TABLE driving_school DROP logo_size');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE client ALTER address DROP NOT NULL');
        $this->addSql('ALTER TABLE client ALTER city DROP NOT NULL');
        $this->addSql('ALTER TABLE client ALTER zip_code DROP NOT NULL');
        $this->addSql('ALTER TABLE client ALTER number DROP NOT NULL');
        $this->addSql('ALTER TABLE client ALTER phone_number DROP NOT NULL');
        $this->addSql('ALTER TABLE driving_school ADD logo_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE driving_school ADD logo_size INT DEFAULT NULL');
    }
}
