<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240803211331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE categoria_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cliente_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE orcamento_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE produto_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE servico_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE categoria (id INT NOT NULL, nome_categoria VARCHAR(80) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cliente (id INT NOT NULL, nome_cliente VARCHAR(60) NOT NULL, contato VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE orcamento (id INT NOT NULL, cliente_id INT DEFAULT NULL, servico_id INT DEFAULT NULL, produto_id INT DEFAULT NULL, titulo_orcamento VARCHAR(120) NOT NULL, data_solicitacao DATE DEFAULT NULL, valor_total INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4B1DD46DDE734E51 ON orcamento (cliente_id)');
        $this->addSql('CREATE INDEX IDX_4B1DD46D82E14982 ON orcamento (servico_id)');
        $this->addSql('CREATE INDEX IDX_4B1DD46D105CFD56 ON orcamento (produto_id)');
        $this->addSql('CREATE TABLE produto (id INT NOT NULL, servico_id INT DEFAULT NULL, quantidade INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5CAC49D782E14982 ON produto (servico_id)');
        $this->addSql('CREATE TABLE servico (id INT NOT NULL, categoria_id INT DEFAULT NULL, nome_servico VARCHAR(80) NOT NULL, descricao_servico VARCHAR(120) NOT NULL, valor INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_14873CC3397707A ON servico (categoria_id)');
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
        $this->addSql('ALTER TABLE orcamento ADD CONSTRAINT FK_4B1DD46DDE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE orcamento ADD CONSTRAINT FK_4B1DD46D82E14982 FOREIGN KEY (servico_id) REFERENCES servico (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE orcamento ADD CONSTRAINT FK_4B1DD46D105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produto ADD CONSTRAINT FK_5CAC49D782E14982 FOREIGN KEY (servico_id) REFERENCES servico (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE servico ADD CONSTRAINT FK_14873CC3397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE categoria_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cliente_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE orcamento_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE produto_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE servico_id_seq CASCADE');
        $this->addSql('ALTER TABLE orcamento DROP CONSTRAINT FK_4B1DD46DDE734E51');
        $this->addSql('ALTER TABLE orcamento DROP CONSTRAINT FK_4B1DD46D82E14982');
        $this->addSql('ALTER TABLE orcamento DROP CONSTRAINT FK_4B1DD46D105CFD56');
        $this->addSql('ALTER TABLE produto DROP CONSTRAINT FK_5CAC49D782E14982');
        $this->addSql('ALTER TABLE servico DROP CONSTRAINT FK_14873CC3397707A');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE orcamento');
        $this->addSql('DROP TABLE produto');
        $this->addSql('DROP TABLE servico');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
