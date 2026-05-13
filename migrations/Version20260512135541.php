<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260512135541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE localite DROP INDEX UNIQ_F5D7E4A9B25F981E, ADD INDEX IDX_F5D7E4A9B25F981E (tresor_id)');
        $this->addSql('ALTER TABLE localite DROP INDEX UNIQ_F5D7E4A93B380EF8, ADD INDEX IDX_F5D7E4A93B380EF8 (regisseurs_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE localite DROP INDEX IDX_F5D7E4A93B380EF8, ADD UNIQUE INDEX UNIQ_F5D7E4A93B380EF8 (regisseurs_id)');
        $this->addSql('ALTER TABLE localite DROP INDEX IDX_F5D7E4A9B25F981E, ADD UNIQUE INDEX UNIQ_F5D7E4A9B25F981E (tresor_id)');
    }
}
