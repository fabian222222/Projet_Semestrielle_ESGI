<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215233041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE driving_school ALTER number SET NOT NULL');
        $this->addSql('ALTER TABLE driving_school ALTER city SET NOT NULL');
        $this->addSql('ALTER TABLE driving_school ALTER zip_code SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE driving_school ALTER number DROP NOT NULL');
        $this->addSql('ALTER TABLE driving_school ALTER city DROP NOT NULL');
        $this->addSql('ALTER TABLE driving_school ALTER zip_code DROP NOT NULL');
    }
}
