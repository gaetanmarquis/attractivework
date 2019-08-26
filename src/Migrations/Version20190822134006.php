<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190822134006 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, personnalite_id INT NOT NULL, email VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, roles VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, nom VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, ville VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, pays VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, photo_profil LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, description_photo VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, date_inscription DATETIME NOT NULL, INDEX IDX_8D93D6492E282BF5 (personnalite_id), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492E282BF5 FOREIGN KEY (personnalite_id) REFERENCES personnalite (id)');
    }
}
