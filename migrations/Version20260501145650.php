<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260501145650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(25) NOT NULL, portefeuille DOUBLE PRECISION NOT NULL, regisseur_id INT DEFAULT NULL, localite_id INT DEFAULT NULL, INDEX IDX_268B9C9D9FBE122E (regisseur_id), INDEX IDX_268B9C9D924DD2B5 (localite_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE carnet_quittance (id INT AUTO_INCREMENT NOT NULL, id_carnet VARCHAR(10) NOT NULL, nb_feuille INT NOT NULL, nb_quittance INT NOT NULL, num_debut VARCHAR(20) NOT NULL, num_fin VARCHAR(20) NOT NULL, date_attribution DATE NOT NULL, statut VARCHAR(20) NOT NULL, agent_id INT DEFAULT NULL, INDEX IDX_7D8A39F23414710B (agent_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE district (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE ligne_versement_agent_vers_regisseur (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, montant DOUBLE PRECISION NOT NULL, type_versement VARCHAR(50) NOT NULL, agent_id INT DEFAULT NULL, regisseur_id INT DEFAULT NULL, INDEX IDX_2C74E1023414710B (agent_id), INDEX IDX_2C74E1029FBE122E (regisseur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE ligne_versement_regisseur_vers_tresor (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, montant DOUBLE PRECISION NOT NULL, regisseur_id INT DEFAULT NULL, tresor_id INT DEFAULT NULL, INDEX IDX_4B5829FF9FBE122E (regisseur_id), INDEX IDX_4B5829FFB25F981E (tresor_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE localite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, district_id INT DEFAULT NULL, regisseurs_id INT DEFAULT NULL, tresor_id INT DEFAULT NULL, INDEX IDX_F5D7E4A9B08FA272 (district_id), UNIQUE INDEX UNIQ_F5D7E4A93B380EF8 (regisseurs_id), UNIQUE INDEX UNIQ_F5D7E4A9B25F981E (tresor_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom_produit VARCHAR(50) NOT NULL, unite_mesure VARCHAR(20) NOT NULL, ristourne DOUBLE PRECISION NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE quittance (id INT AUTO_INCREMENT NOT NULL, num_quittance VARCHAR(20) NOT NULL, date_utilisation DATE NOT NULL, nom_client VARCHAR(255) NOT NULL, quantite INT NOT NULL, montant_total DOUBLE PRECISION NOT NULL, carnet_quittance_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, INDEX IDX_D57587DDD3E88577 (carnet_quittance_id), INDEX IDX_D57587DDF347EFB (produit_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE regisseur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(25) NOT NULL, portefeuille DOUBLE PRECISION NOT NULL, tresor_id INT DEFAULT NULL, INDEX IDX_A41A7CDEB25F981E (tresor_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE tresor (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, portefeuille DOUBLE PRECISION NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D9FBE122E FOREIGN KEY (regisseur_id) REFERENCES regisseur (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D924DD2B5 FOREIGN KEY (localite_id) REFERENCES localite (id)');
        $this->addSql('ALTER TABLE carnet_quittance ADD CONSTRAINT FK_7D8A39F23414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE ligne_versement_agent_vers_regisseur ADD CONSTRAINT FK_2C74E1023414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE ligne_versement_agent_vers_regisseur ADD CONSTRAINT FK_2C74E1029FBE122E FOREIGN KEY (regisseur_id) REFERENCES regisseur (id)');
        $this->addSql('ALTER TABLE ligne_versement_regisseur_vers_tresor ADD CONSTRAINT FK_4B5829FF9FBE122E FOREIGN KEY (regisseur_id) REFERENCES regisseur (id)');
        $this->addSql('ALTER TABLE ligne_versement_regisseur_vers_tresor ADD CONSTRAINT FK_4B5829FFB25F981E FOREIGN KEY (tresor_id) REFERENCES tresor (id)');
        $this->addSql('ALTER TABLE localite ADD CONSTRAINT FK_F5D7E4A9B08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        $this->addSql('ALTER TABLE localite ADD CONSTRAINT FK_F5D7E4A93B380EF8 FOREIGN KEY (regisseurs_id) REFERENCES regisseur (id)');
        $this->addSql('ALTER TABLE localite ADD CONSTRAINT FK_F5D7E4A9B25F981E FOREIGN KEY (tresor_id) REFERENCES tresor (id)');
        $this->addSql('ALTER TABLE quittance ADD CONSTRAINT FK_D57587DDD3E88577 FOREIGN KEY (carnet_quittance_id) REFERENCES carnet_quittance (id)');
        $this->addSql('ALTER TABLE quittance ADD CONSTRAINT FK_D57587DDF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE regisseur ADD CONSTRAINT FK_A41A7CDEB25F981E FOREIGN KEY (tresor_id) REFERENCES tresor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D9FBE122E');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D924DD2B5');
        $this->addSql('ALTER TABLE carnet_quittance DROP FOREIGN KEY FK_7D8A39F23414710B');
        $this->addSql('ALTER TABLE ligne_versement_agent_vers_regisseur DROP FOREIGN KEY FK_2C74E1023414710B');
        $this->addSql('ALTER TABLE ligne_versement_agent_vers_regisseur DROP FOREIGN KEY FK_2C74E1029FBE122E');
        $this->addSql('ALTER TABLE ligne_versement_regisseur_vers_tresor DROP FOREIGN KEY FK_4B5829FF9FBE122E');
        $this->addSql('ALTER TABLE ligne_versement_regisseur_vers_tresor DROP FOREIGN KEY FK_4B5829FFB25F981E');
        $this->addSql('ALTER TABLE localite DROP FOREIGN KEY FK_F5D7E4A9B08FA272');
        $this->addSql('ALTER TABLE localite DROP FOREIGN KEY FK_F5D7E4A93B380EF8');
        $this->addSql('ALTER TABLE localite DROP FOREIGN KEY FK_F5D7E4A9B25F981E');
        $this->addSql('ALTER TABLE quittance DROP FOREIGN KEY FK_D57587DDD3E88577');
        $this->addSql('ALTER TABLE quittance DROP FOREIGN KEY FK_D57587DDF347EFB');
        $this->addSql('ALTER TABLE regisseur DROP FOREIGN KEY FK_A41A7CDEB25F981E');
        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE carnet_quittance');
        $this->addSql('DROP TABLE district');
        $this->addSql('DROP TABLE ligne_versement_agent_vers_regisseur');
        $this->addSql('DROP TABLE ligne_versement_regisseur_vers_tresor');
        $this->addSql('DROP TABLE localite');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE quittance');
        $this->addSql('DROP TABLE regisseur');
        $this->addSql('DROP TABLE tresor');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
