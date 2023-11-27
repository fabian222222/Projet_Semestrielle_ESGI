<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231127185841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE quotation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE quotation_detail_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE contract_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contract_detail_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE contract (id INT NOT NULL, client_id INT DEFAULT NULL, driving_school_id INT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, description TEXT NOT NULL, validity_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E98F285919EB6921 ON contract (client_id)');
        $this->addSql('CREATE INDEX IDX_E98F2859EBF3DFE7 ON contract (driving_school_id)');
        $this->addSql('CREATE TABLE contract_detail (id INT NOT NULL, contract_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, hour INT NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_12469ADE2576E0FD ON contract_detail (contract_id)');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F285919EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859EBF3DFE7 FOREIGN KEY (driving_school_id) REFERENCES driving_school (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract_detail ADD CONSTRAINT FK_12469ADE2576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quotation_detail DROP CONSTRAINT fk_d476b509b4ea4e60');
        $this->addSql('ALTER TABLE quotation DROP CONSTRAINT fk_474a8db919eb6921');
        $this->addSql('DROP TABLE quotation_detail');
        $this->addSql('DROP TABLE quotation');
        $this->addSql('ALTER TABLE invoice DROP CONSTRAINT fk_9065174419eb6921');
        $this->addSql('DROP INDEX idx_9065174419eb6921');
        $this->addSql('ALTER TABLE invoice DROP name_service');
        $this->addSql('ALTER TABLE invoice RENAME COLUMN client_id TO driving_school_id');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744EBF3DFE7 FOREIGN KEY (driving_school_id) REFERENCES driving_school (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_90651744EBF3DFE7 ON invoice (driving_school_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE contract_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contract_detail_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE quotation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE quotation_detail_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE quotation_detail (id INT NOT NULL, quotation_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, hour INT NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_d476b509b4ea4e60 ON quotation_detail (quotation_id)');
        $this->addSql('CREATE TABLE quotation (id INT NOT NULL, client_id INT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, description TEXT NOT NULL, date_validity DATE NOT NULL, name_service TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_474a8db919eb6921 ON quotation (client_id)');
        $this->addSql('ALTER TABLE quotation_detail ADD CONSTRAINT fk_d476b509b4ea4e60 FOREIGN KEY (quotation_id) REFERENCES quotation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT fk_474a8db919eb6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract DROP CONSTRAINT FK_E98F285919EB6921');
        $this->addSql('ALTER TABLE contract DROP CONSTRAINT FK_E98F2859EBF3DFE7');
        $this->addSql('ALTER TABLE contract_detail DROP CONSTRAINT FK_12469ADE2576E0FD');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE contract_detail');
        $this->addSql('ALTER TABLE invoice DROP CONSTRAINT FK_90651744EBF3DFE7');
        $this->addSql('DROP INDEX IDX_90651744EBF3DFE7');
        $this->addSql('ALTER TABLE invoice ADD name_service VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE invoice RENAME COLUMN driving_school_id TO client_id');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT fk_9065174419eb6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_9065174419eb6921 ON invoice (client_id)');
    }
}
