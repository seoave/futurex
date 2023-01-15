<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230107230438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER INDEX idx_29d6873e9d86650f RENAME TO IDX_29D6873EA76ED395');
        $this->addSql('ALTER INDEX idx_29d6873e28a69c31 RENAME TO IDX_29D6873E38248176');
        $this->addSql('ALTER INDEX idx_f5299398609b92b6 RENAME TO IDX_F52993982675F8C');
        $this->addSql('ALTER INDEX idx_f5299398fc69e3be RENAME TO IDX_F529939853C674EE');
        $this->addSql('ALTER TABLE wallet DROP CONSTRAINT fk_7c68921f9d86650f');
        $this->addSql('DROP INDEX idx_7c68921f9d86650f');
        $this->addSql('ALTER TABLE wallet RENAME COLUMN user_id TO owner_id');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7C68921F7E3C61F9 ON wallet (owner_id)');
        $this->addSql('ALTER INDEX idx_7c68921f28a69c31 RENAME TO IDX_7C68921F38248176');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE wallet DROP CONSTRAINT FK_7C68921F7E3C61F9');
        $this->addSql('DROP INDEX IDX_7C68921F7E3C61F9');
        $this->addSql('ALTER TABLE wallet RENAME COLUMN owner_id TO user_id');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT fk_7c68921f9d86650f FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_7c68921f9d86650f ON wallet (user_id)');
        $this->addSql('ALTER INDEX idx_7c68921f38248176 RENAME TO idx_7c68921f28a69c31');
        $this->addSql('ALTER INDEX idx_29d6873e38248176 RENAME TO idx_29d6873e28a69c31');
        $this->addSql('ALTER INDEX idx_29d6873ea76ed395 RENAME TO idx_29d6873e9d86650f');
        $this->addSql('ALTER INDEX idx_f529939853c674ee RENAME TO idx_f5299398fc69e3be');
        $this->addSql('ALTER INDEX idx_f52993982675f8c RENAME TO idx_f5299398609b92b6');
    }
}
