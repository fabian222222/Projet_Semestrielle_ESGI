<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219135316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD product_hour INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD product_price INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE product ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE product ADD deleted_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE product ADD validity_date DATE NOT NULL');
        $this->addSql('ALTER TABLE product DROP hour');
        $this->addSql('ALTER TABLE product DROP price');
        $this->addSql('ALTER TABLE product RENAME COLUMN name TO product_name');
        $this->addSql('ALTER TABLE product RENAME COLUMN description TO product_description');
        $this->addSql('COMMENT ON COLUMN product.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN product.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN product.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN product.validity_date IS \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product ADD hour INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD price INT NOT NULL');
        $this->addSql('ALTER TABLE product DROP product_hour');
        $this->addSql('ALTER TABLE product DROP product_price');
        $this->addSql('ALTER TABLE product DROP created_at');
        $this->addSql('ALTER TABLE product DROP updated_at');
        $this->addSql('ALTER TABLE product DROP deleted_at');
        $this->addSql('ALTER TABLE product DROP validity_date');
        $this->addSql('ALTER TABLE product RENAME COLUMN product_name TO name');
        $this->addSql('ALTER TABLE product RENAME COLUMN product_description TO description');
    }
}
