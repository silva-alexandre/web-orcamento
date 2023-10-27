<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230826012320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, nome_cliente VARCHAR(60) NOT NULL, contato VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orcamento (id INT AUTO_INCREMENT NOT NULL, cliente_id INT DEFAULT NULL, servico_id INT DEFAULT NULL, produto_id INT DEFAULT NULL, titulo_orcamento VARCHAR(120) NOT NULL, data_solicitacao DATE DEFAULT NULL, INDEX IDX_4B1DD46DDE734E51 (cliente_id), INDEX IDX_4B1DD46D82E14982 (servico_id), INDEX IDX_4B1DD46D105CFD56 (produto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produto (id INT AUTO_INCREMENT NOT NULL, servico_id INT DEFAULT NULL, quantidade INT NOT NULL, INDEX IDX_5CAC49D782E14982 (servico_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orcamento ADD CONSTRAINT FK_4B1DD46DDE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE orcamento ADD CONSTRAINT FK_4B1DD46D82E14982 FOREIGN KEY (servico_id) REFERENCES servico (id)');
        $this->addSql('ALTER TABLE orcamento ADD CONSTRAINT FK_4B1DD46D105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id)');
        $this->addSql('ALTER TABLE produto ADD CONSTRAINT FK_5CAC49D782E14982 FOREIGN KEY (servico_id) REFERENCES servico (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orcamento DROP FOREIGN KEY FK_4B1DD46DDE734E51');
        $this->addSql('ALTER TABLE orcamento DROP FOREIGN KEY FK_4B1DD46D82E14982');
        $this->addSql('ALTER TABLE orcamento DROP FOREIGN KEY FK_4B1DD46D105CFD56');
        $this->addSql('ALTER TABLE produto DROP FOREIGN KEY FK_5CAC49D782E14982');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE orcamento');
        $this->addSql('DROP TABLE produto');
    }
}
