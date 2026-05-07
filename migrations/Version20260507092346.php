<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260507092346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quittance ADD statut VARCHAR(20) DEFAULT NULL, ADD ecart DOUBLE PRECISION DEFAULT NULL, ADD versement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quittance ADD CONSTRAINT FK_D57587DDDBBF8D62 FOREIGN KEY (versement_id) REFERENCES ligne_versement_agent_vers_regisseur (id)');
        $this->addSql('CREATE INDEX IDX_D57587DDDBBF8D62 ON quittance (versement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quittance DROP FOREIGN KEY FK_D57587DDDBBF8D62');
        $this->addSql('DROP INDEX IDX_D57587DDDBBF8D62 ON quittance');
        $this->addSql('ALTER TABLE quittance DROP statut, DROP ecart, DROP versement_id');
    }
}
