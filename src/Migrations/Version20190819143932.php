<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190819143932 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE candidat (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, date_naissance DATETIME NOT NULL, telephone INT NOT NULL, cv VARCHAR(255) DEFAULT NULL, autre_fichier VARCHAR(255) DEFAULT NULL, atout LONGTEXT DEFAULT NULL, site_web LONGTEXT DEFAULT NULL, salaire INT DEFAULT NULL, date_disponibilite DATETIME DEFAULT NULL, type_contrat VARCHAR(50) DEFAULT NULL, metier VARCHAR(100) NOT NULL, annee_experience INT NOT NULL, langue_parlee VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_6AB5B4716A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, candidat_id INT NOT NULL, recruteur_id INT NOT NULL, date_like DATETIME NOT NULL, INDEX IDX_AC6340B38D0EB82 (candidat_id), INDEX IDX_AC6340B3BB0859F1 (recruteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `match` (id INT AUTO_INCREMENT NOT NULL, candidat_id INT NOT NULL, recruteur_id INT NOT NULL, date_match DATETIME NOT NULL, INDEX IDX_7A5BC5058D0EB82 (candidat_id), INDEX IDX_7A5BC505BB0859F1 (recruteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, personnalite_id INT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, mdp VARCHAR(255) NOT NULL, ville VARCHAR(100) NOT NULL, pays VARCHAR(50) NOT NULL, photo_profil LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, statut VARCHAR(255) NOT NULL, date_inscription DATETIME NOT NULL, INDEX IDX_F6B4FB292E282BF5 (personnalite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, candidat_id INT NOT NULL, recruteur_id INT NOT NULL, messagze LONGTEXT NOT NULL, date_message DATETIME NOT NULL, INDEX IDX_B6BD307F8D0EB82 (candidat_id), INDEX IDX_B6BD307FBB0859F1 (recruteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, recruteur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description_poste LONGTEXT NOT NULL, salaire_poste INT NOT NULL, ville_poste VARCHAR(100) NOT NULL, pays_poste VARCHAR(50) NOT NULL, date_publication DATETIME NOT NULL, INDEX IDX_AF86866FBB0859F1 (recruteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnalite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, reference VARCHAR(4) NOT NULL, categorie VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recruteur (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, nbr_employe INT DEFAULT NULL, secteur_activite VARCHAR(100) NOT NULL, logo_entreprise LONGTEXT NOT NULL, nom_entreprise VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_2BD3678C6A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B4716A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B38D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3BB0859F1 FOREIGN KEY (recruteur_id) REFERENCES recruteur (id)');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_7A5BC5058D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_7A5BC505BB0859F1 FOREIGN KEY (recruteur_id) REFERENCES recruteur (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB292E282BF5 FOREIGN KEY (personnalite_id) REFERENCES personnalite (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FBB0859F1 FOREIGN KEY (recruteur_id) REFERENCES recruteur (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FBB0859F1 FOREIGN KEY (recruteur_id) REFERENCES recruteur (id)');
        $this->addSql('ALTER TABLE recruteur ADD CONSTRAINT FK_2BD3678C6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B38D0EB82');
        $this->addSql('ALTER TABLE `match` DROP FOREIGN KEY FK_7A5BC5058D0EB82');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F8D0EB82');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B4716A99F74A');
        $this->addSql('ALTER TABLE recruteur DROP FOREIGN KEY FK_2BD3678C6A99F74A');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB292E282BF5');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3BB0859F1');
        $this->addSql('ALTER TABLE `match` DROP FOREIGN KEY FK_7A5BC505BB0859F1');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FBB0859F1');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FBB0859F1');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP TABLE `match`');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE personnalite');
        $this->addSql('DROP TABLE recruteur');
    }
}
