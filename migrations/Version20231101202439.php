<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231101202439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE page_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE page_meta_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE page (id INT NOT NULL, name VARCHAR(500) NOT NULL, status SMALLINT NOT NULL, type SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE page_meta (id INT NOT NULL, page_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(500) NOT NULL, meta_title VARCHAR(60) NOT NULL, meta_description VARCHAR(160) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_503608EFC4663E4 ON page_meta (page_id)');
        $this->addSql('ALTER TABLE page_meta ADD CONSTRAINT FK_503608EFC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE page_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE page_meta_id_seq CASCADE');
        $this->addSql('ALTER TABLE page_meta DROP CONSTRAINT FK_503608EFC4663E4');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_meta');
    }
}
