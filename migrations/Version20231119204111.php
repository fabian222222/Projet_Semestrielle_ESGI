<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231119204111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE formule_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE formula_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE formula (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, hour INT NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE formula_detail (formula_id INT NOT NULL, detail_id INT NOT NULL, PRIMARY KEY(formula_id, detail_id))');
        $this->addSql('CREATE INDEX IDX_2339AD40A50A6386 ON formula_detail (formula_id)');
        $this->addSql('CREATE INDEX IDX_2339AD40D8D003BB ON formula_detail (detail_id)');
        $this->addSql('CREATE TABLE service_formula (service_id INT NOT NULL, formula_id INT NOT NULL, PRIMARY KEY(service_id, formula_id))');
        $this->addSql('CREATE INDEX IDX_A8B50A1DED5CA9E6 ON service_formula (service_id)');
        $this->addSql('CREATE INDEX IDX_A8B50A1DA50A6386 ON service_formula (formula_id)');
        $this->addSql('ALTER TABLE formula_detail ADD CONSTRAINT FK_2339AD40A50A6386 FOREIGN KEY (formula_id) REFERENCES formula (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formula_detail ADD CONSTRAINT FK_2339AD40D8D003BB FOREIGN KEY (detail_id) REFERENCES detail (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_formula ADD CONSTRAINT FK_A8B50A1DED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_formula ADD CONSTRAINT FK_A8B50A1DA50A6386 FOREIGN KEY (formula_id) REFERENCES formula (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formule_detail DROP CONSTRAINT fk_a773a3ba2a68f4d1');
        $this->addSql('ALTER TABLE formule_detail DROP CONSTRAINT fk_a773a3bad8d003bb');
        $this->addSql('ALTER TABLE service_formule DROP CONSTRAINT fk_afd8ce04ed5ca9e6');
        $this->addSql('ALTER TABLE service_formule DROP CONSTRAINT fk_afd8ce042a68f4d1');
        $this->addSql('DROP TABLE formule_detail');
        $this->addSql('DROP TABLE formule');
        $this->addSql('DROP TABLE service_formule');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE formula_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE formule_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE formule_detail (formule_id INT NOT NULL, detail_id INT NOT NULL, PRIMARY KEY(formule_id, detail_id))');
        $this->addSql('CREATE INDEX idx_a773a3bad8d003bb ON formule_detail (detail_id)');
        $this->addSql('CREATE INDEX idx_a773a3ba2a68f4d1 ON formule_detail (formule_id)');
        $this->addSql('CREATE TABLE formule (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, hour INT NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE service_formule (service_id INT NOT NULL, formule_id INT NOT NULL, PRIMARY KEY(service_id, formule_id))');
        $this->addSql('CREATE INDEX idx_afd8ce042a68f4d1 ON service_formule (formule_id)');
        $this->addSql('CREATE INDEX idx_afd8ce04ed5ca9e6 ON service_formule (service_id)');
        $this->addSql('ALTER TABLE formule_detail ADD CONSTRAINT fk_a773a3ba2a68f4d1 FOREIGN KEY (formule_id) REFERENCES formule (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formule_detail ADD CONSTRAINT fk_a773a3bad8d003bb FOREIGN KEY (detail_id) REFERENCES detail (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_formule ADD CONSTRAINT fk_afd8ce04ed5ca9e6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_formule ADD CONSTRAINT fk_afd8ce042a68f4d1 FOREIGN KEY (formule_id) REFERENCES formule (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formula_detail DROP CONSTRAINT FK_2339AD40A50A6386');
        $this->addSql('ALTER TABLE formula_detail DROP CONSTRAINT FK_2339AD40D8D003BB');
        $this->addSql('ALTER TABLE service_formula DROP CONSTRAINT FK_A8B50A1DED5CA9E6');
        $this->addSql('ALTER TABLE service_formula DROP CONSTRAINT FK_A8B50A1DA50A6386');
        $this->addSql('DROP TABLE formula');
        $this->addSql('DROP TABLE formula_detail');
        $this->addSql('DROP TABLE service_formula');
    }
}
