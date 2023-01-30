<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230122150810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT fk_f5299398609b92b6');
        $this->addSql('DROP INDEX idx_f52993982675f8c');
        $this->addSql('ALTER TABLE "order" ADD recipient_offer_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" RENAME COLUMN acceptor_id TO payer_offer_id');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398196238C3 FOREIGN KEY (payer_offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398BDDE25EA FOREIGN KEY (recipient_offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F5299398196238C3 ON "order" (payer_offer_id)');
        $this->addSql('CREATE INDEX IDX_F5299398BDDE25EA ON "order" (recipient_offer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398196238C3');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398BDDE25EA');
        $this->addSql('DROP INDEX IDX_F5299398196238C3');
        $this->addSql('DROP INDEX IDX_F5299398BDDE25EA');
        $this->addSql('ALTER TABLE "order" ADD acceptor_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" DROP payer_offer_id');
        $this->addSql('ALTER TABLE "order" DROP recipient_offer_id');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT fk_f5299398609b92b6 FOREIGN KEY (acceptor_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f52993982675f8c ON "order" (acceptor_id)');
    }
}
