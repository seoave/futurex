<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230128095711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT fk_f5299398196238c3');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT fk_f5299398bdde25ea');
        $this->addSql('DROP INDEX idx_f5299398bdde25ea');
        $this->addSql('DROP INDEX idx_f5299398196238c3');
        $this->addSql('ALTER TABLE "order" ADD initial_offer_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD match_offer_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" DROP payer_offer_id');
        $this->addSql('ALTER TABLE "order" DROP recipient_offer_id');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F52993988B7F2D5E FOREIGN KEY (initial_offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F52993988EBCAE78 FOREIGN KEY (match_offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F52993988B7F2D5E ON "order" (initial_offer_id)');
        $this->addSql('CREATE INDEX IDX_F52993988EBCAE78 ON "order" (match_offer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F52993988B7F2D5E');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F52993988EBCAE78');
        $this->addSql('DROP INDEX IDX_F52993988B7F2D5E');
        $this->addSql('DROP INDEX IDX_F52993988EBCAE78');
        $this->addSql('ALTER TABLE "order" ADD payer_offer_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD recipient_offer_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" DROP initial_offer_id');
        $this->addSql('ALTER TABLE "order" DROP match_offer_id');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT fk_f5299398196238c3 FOREIGN KEY (payer_offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT fk_f5299398bdde25ea FOREIGN KEY (recipient_offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f5299398bdde25ea ON "order" (recipient_offer_id)');
        $this->addSql('CREATE INDEX idx_f5299398196238c3 ON "order" (payer_offer_id)');
    }
}
