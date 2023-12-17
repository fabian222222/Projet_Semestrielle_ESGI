<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215184141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_driving_school (user_id INT NOT NULL, driving_school_id INT NOT NULL, PRIMARY KEY(user_id, driving_school_id))');
        $this->addSql('CREATE INDEX IDX_A8379F22A76ED395 ON user_driving_school (user_id)');
        $this->addSql('CREATE INDEX IDX_A8379F22EBF3DFE7 ON user_driving_school (driving_school_id)');
        $this->addSql('ALTER TABLE user_driving_school ADD CONSTRAINT FK_A8379F22A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_driving_school ADD CONSTRAINT FK_A8379F22EBF3DFE7 FOREIGN KEY (driving_school_id) REFERENCES driving_school (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE invoice ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_9065174419EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9065174419EB6921 ON invoice (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_driving_school DROP CONSTRAINT FK_A8379F22A76ED395');
        $this->addSql('ALTER TABLE user_driving_school DROP CONSTRAINT FK_A8379F22EBF3DFE7');
        $this->addSql('DROP TABLE user_driving_school');
        $this->addSql('ALTER TABLE invoice DROP CONSTRAINT FK_9065174419EB6921');
        $this->addSql('DROP INDEX IDX_9065174419EB6921');
        $this->addSql('ALTER TABLE invoice DROP client_id');
    }
}
