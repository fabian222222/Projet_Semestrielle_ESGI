<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231123214713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE detail_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE service_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE quotation_detail_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE formula_product (formula_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(formula_id, product_id))');
        $this->addSql('CREATE INDEX IDX_CC9DB811A50A6386 ON formula_product (formula_id)');
        $this->addSql('CREATE INDEX IDX_CC9DB8114584665A ON formula_product (product_id)');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, hour INT NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE quotation_detail (id INT NOT NULL, quotation_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, hour INT NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D476B509B4EA4E60 ON quotation_detail (quotation_id)');
        $this->addSql('ALTER TABLE formula_product ADD CONSTRAINT FK_CC9DB811A50A6386 FOREIGN KEY (formula_id) REFERENCES formula (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formula_product ADD CONSTRAINT FK_CC9DB8114584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quotation_detail ADD CONSTRAINT FK_D476B509B4EA4E60 FOREIGN KEY (quotation_id) REFERENCES quotation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_formula DROP CONSTRAINT fk_a8b50a1ded5ca9e6');
        $this->addSql('ALTER TABLE service_formula DROP CONSTRAINT fk_a8b50a1da50a6386');
        $this->addSql('ALTER TABLE formula_detail DROP CONSTRAINT fk_2339ad40a50a6386');
        $this->addSql('ALTER TABLE formula_detail DROP CONSTRAINT fk_2339ad40d8d003bb');
        $this->addSql('ALTER TABLE user_driving_school DROP CONSTRAINT fk_a8379f22a76ed395');
        $this->addSql('ALTER TABLE user_driving_school DROP CONSTRAINT fk_a8379f22ebf3dfe7');
        $this->addSql('DROP TABLE service_formula');
        $this->addSql('DROP TABLE formula_detail');
        $this->addSql('DROP TABLE user_driving_school');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE detail');
        $this->addSql('ALTER TABLE client ADD driving_school_id INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455EBF3DFE7 FOREIGN KEY (driving_school_id) REFERENCES driving_school (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C7440455EBF3DFE7 ON client (driving_school_id)');
        $this->addSql('ALTER TABLE formula ADD driving_school_id INT NOT NULL');
        $this->addSql('ALTER TABLE formula ADD type_license_driving VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE formula DROP hour');
        $this->addSql('ALTER TABLE formula DROP price');
        $this->addSql('ALTER TABLE formula ADD CONSTRAINT FK_67315881EBF3DFE7 FOREIGN KEY (driving_school_id) REFERENCES driving_school (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_67315881EBF3DFE7 ON formula (driving_school_id)');
        $this->addSql('ALTER TABLE invoice_detail ADD invoice_id INT NOT NULL');
        $this->addSql('ALTER TABLE invoice_detail ADD hour INT NOT NULL');
        $this->addSql('ALTER TABLE invoice_detail ADD CONSTRAINT FK_9530E2C02989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9530E2C02989F1FD ON invoice_detail (invoice_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE quotation_detail_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE detail_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE service_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE service_formula (service_id INT NOT NULL, formula_id INT NOT NULL, PRIMARY KEY(service_id, formula_id))');
        $this->addSql('CREATE INDEX idx_a8b50a1da50a6386 ON service_formula (formula_id)');
        $this->addSql('CREATE INDEX idx_a8b50a1ded5ca9e6 ON service_formula (service_id)');
        $this->addSql('CREATE TABLE formula_detail (formula_id INT NOT NULL, detail_id INT NOT NULL, PRIMARY KEY(formula_id, detail_id))');
        $this->addSql('CREATE INDEX idx_2339ad40d8d003bb ON formula_detail (detail_id)');
        $this->addSql('CREATE INDEX idx_2339ad40a50a6386 ON formula_detail (formula_id)');
        $this->addSql('CREATE TABLE user_driving_school (user_id INT NOT NULL, driving_school_id INT NOT NULL, PRIMARY KEY(user_id, driving_school_id))');
        $this->addSql('CREATE INDEX idx_a8379f22ebf3dfe7 ON user_driving_school (driving_school_id)');
        $this->addSql('CREATE INDEX idx_a8379f22a76ed395 ON user_driving_school (user_id)');
        $this->addSql('CREATE TABLE service (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, license_type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE detail (id INT NOT NULL, description TEXT NOT NULL, price INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE service_formula ADD CONSTRAINT fk_a8b50a1ded5ca9e6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_formula ADD CONSTRAINT fk_a8b50a1da50a6386 FOREIGN KEY (formula_id) REFERENCES formula (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formula_detail ADD CONSTRAINT fk_2339ad40a50a6386 FOREIGN KEY (formula_id) REFERENCES formula (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formula_detail ADD CONSTRAINT fk_2339ad40d8d003bb FOREIGN KEY (detail_id) REFERENCES detail (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_driving_school ADD CONSTRAINT fk_a8379f22a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_driving_school ADD CONSTRAINT fk_a8379f22ebf3dfe7 FOREIGN KEY (driving_school_id) REFERENCES driving_school (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formula_product DROP CONSTRAINT FK_CC9DB811A50A6386');
        $this->addSql('ALTER TABLE formula_product DROP CONSTRAINT FK_CC9DB8114584665A');
        $this->addSql('ALTER TABLE quotation_detail DROP CONSTRAINT FK_D476B509B4EA4E60');
        $this->addSql('DROP TABLE formula_product');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE quotation_detail');
        $this->addSql('ALTER TABLE client DROP CONSTRAINT FK_C7440455EBF3DFE7');
        $this->addSql('DROP INDEX IDX_C7440455EBF3DFE7');
        $this->addSql('ALTER TABLE client DROP driving_school_id');
        $this->addSql('ALTER TABLE formula DROP CONSTRAINT FK_67315881EBF3DFE7');
        $this->addSql('DROP INDEX IDX_67315881EBF3DFE7');
        $this->addSql('ALTER TABLE formula ADD price INT NOT NULL');
        $this->addSql('ALTER TABLE formula DROP type_license_driving');
        $this->addSql('ALTER TABLE formula RENAME COLUMN driving_school_id TO hour');
        $this->addSql('ALTER TABLE invoice_detail DROP CONSTRAINT FK_9530E2C02989F1FD');
        $this->addSql('DROP INDEX IDX_9530E2C02989F1FD');
        $this->addSql('ALTER TABLE invoice_detail DROP invoice_id');
        $this->addSql('ALTER TABLE invoice_detail DROP hour');
    }
}
