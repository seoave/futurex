<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104212850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offer RENAME COLUMN currency_id TO currency_id_id');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E28A69C31 FOREIGN KEY (currency_id_id) REFERENCES currency (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_29D6873E28A69C31 ON offer (currency_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('ALTER TABLE offer DROP CONSTRAINT FK_29D6873E28A69C31');
        $this->addSql('DROP INDEX IDX_29D6873E28A69C31');
        $this->addSql('ALTER TABLE offer RENAME COLUMN currency_id_id TO currency_id');
    }
}
