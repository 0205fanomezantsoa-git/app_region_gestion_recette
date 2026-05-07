<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260502070758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carnet_quittance ADD nb_quittance_restant INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quittance DROP nb_quittance_restant');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carnet_quittance DROP nb_quittance_restant');
        $this->addSql('ALTER TABLE quittance ADD nb_quittance_restant INT DEFAULT NULL');
    }
}
