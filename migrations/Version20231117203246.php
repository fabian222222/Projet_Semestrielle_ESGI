<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231117203246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE detail_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE driving_school_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE formule_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE invoice_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE invoice_detail_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE payment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE quotation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE service_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE detail (id INT NOT NULL, description TEXT NOT NULL, price INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE driving_school (id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, siret VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE formule (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, hour INT NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE formule_detail (formule_id INT NOT NULL, detail_id INT NOT NULL, PRIMARY KEY(formule_id, detail_id))');
        $this->addSql('CREATE INDEX IDX_A773A3BA2A68F4D1 ON formule_detail (formule_id)');
        $this->addSql('CREATE INDEX IDX_A773A3BAD8D003BB ON formule_detail (detail_id)');
        $this->addSql('CREATE TABLE invoice (id INT NOT NULL, client_id INT NOT NULL, name VARCHAR(255) NOT NULL, date DATE NOT NULL, type_payment VARCHAR(255) NOT NULL, price INT NOT NULL, name_service VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9065174419EB6921 ON invoice (client_id)');
        $this->addSql('CREATE TABLE invoice_detail (id INT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE payment (id INT NOT NULL, status_id INT NOT NULL, invoice_id INT NOT NULL, date DATE NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6D28840D6BF700BD ON payment (status_id)');
        $this->addSql('CREATE INDEX IDX_6D28840D2989F1FD ON payment (invoice_id)');
        $this->addSql('CREATE TABLE quotation (id INT NOT NULL, client_id INT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, description TEXT NOT NULL, date_validity DATE NOT NULL, name_service TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_474A8DB919EB6921 ON quotation (client_id)');
        $this->addSql('CREATE TABLE service (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, license_type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE service_formule (service_id INT NOT NULL, formule_id INT NOT NULL, PRIMARY KEY(service_id, formule_id))');
        $this->addSql('CREATE INDEX IDX_AFD8CE04ED5CA9E6 ON service_formule (service_id)');
        $this->addSql('CREATE INDEX IDX_AFD8CE042A68F4D1 ON service_formule (formule_id)');
        $this->addSql('CREATE TABLE status (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE user_driving_school (user_id INT NOT NULL, driving_school_id INT NOT NULL, PRIMARY KEY(user_id, driving_school_id))');
        $this->addSql('CREATE INDEX IDX_A8379F22A76ED395 ON user_driving_school (user_id)');
        $this->addSql('CREATE INDEX IDX_A8379F22EBF3DFE7 ON user_driving_school (driving_school_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE formule_detail ADD CONSTRAINT FK_A773A3BA2A68F4D1 FOREIGN KEY (formule_id) REFERENCES formule (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formule_detail ADD CONSTRAINT FK_A773A3BAD8D003BB FOREIGN KEY (detail_id) REFERENCES detail (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_9065174419EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D6BF700BD FOREIGN KEY (status_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D2989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB919EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_formule ADD CONSTRAINT FK_AFD8CE04ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_formule ADD CONSTRAINT FK_AFD8CE042A68F4D1 FOREIGN KEY (formule_id) REFERENCES formule (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_driving_school ADD CONSTRAINT FK_A8379F22A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_driving_school ADD CONSTRAINT FK_A8379F22EBF3DFE7 FOREIGN KEY (driving_school_id) REFERENCES driving_school (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE detail_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE driving_school_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE formule_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE invoice_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE invoice_detail_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE payment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE quotation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE service_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE formule_detail DROP CONSTRAINT FK_A773A3BA2A68F4D1');
        $this->addSql('ALTER TABLE formule_detail DROP CONSTRAINT FK_A773A3BAD8D003BB');
        $this->addSql('ALTER TABLE invoice DROP CONSTRAINT FK_9065174419EB6921');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D6BF700BD');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D2989F1FD');
        $this->addSql('ALTER TABLE quotation DROP CONSTRAINT FK_474A8DB919EB6921');
        $this->addSql('ALTER TABLE service_formule DROP CONSTRAINT FK_AFD8CE04ED5CA9E6');
        $this->addSql('ALTER TABLE service_formule DROP CONSTRAINT FK_AFD8CE042A68F4D1');
        $this->addSql('ALTER TABLE user_driving_school DROP CONSTRAINT FK_A8379F22A76ED395');
        $this->addSql('ALTER TABLE user_driving_school DROP CONSTRAINT FK_A8379F22EBF3DFE7');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE detail');
        $this->addSql('DROP TABLE driving_school');
        $this->addSql('DROP TABLE formule');
        $this->addSql('DROP TABLE formule_detail');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE invoice_detail');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE quotation');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_formule');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_driving_school');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
