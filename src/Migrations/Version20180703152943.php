<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180703152943 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dispo_vehicule (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, status_facture_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_FE86641064D218E (location_id), INDEX IDX_FE8664107E7E0A8E (status_facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, status_location_id INT DEFAULT NULL, vehicule_id INT DEFAULT NULL, user_id INT DEFAULT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, return_date DATETIME DEFAULT NULL, return_km INT DEFAULT NULL, INDEX IDX_5E9E89CB297547F (status_location_id), INDEX IDX_5E9E89CB4A4A3511 (vehicule_id), INDEX IDX_5E9E89CBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status_facture (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status_location (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_user (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_vehicule (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, type_user_id INT DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, birth_date DATETIME DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, fidelity_point INT DEFAULT NULL, tel_num INT DEFAULT NULL, licence_num VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D6498F4FBC60 (type_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, type_vehicule_id INT DEFAULT NULL, dispo_vehicule_id INT DEFAULT NULL, agence_id INT DEFAULT NULL, marque_id INT DEFAULT NULL, modele VARCHAR(255) DEFAULT NULL, num_serie VARCHAR(255) DEFAULT NULL, couleur VARCHAR(255) DEFAULT NULL, plaque_imma VARCHAR(255) DEFAULT NULL, nb_km INT DEFAULT NULL, date_achat DATETIME DEFAULT NULL, prix_achat DOUBLE PRECISION DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_292FFF1D153E280 (type_vehicule_id), INDEX IDX_292FFF1D96D74F5E (dispo_vehicule_id), INDEX IDX_292FFF1DD725330D (agence_id), INDEX IDX_292FFF1D4827B9B2 (marque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641064D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664107E7E0A8E FOREIGN KEY (status_facture_id) REFERENCES status_facture (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB297547F FOREIGN KEY (status_location_id) REFERENCES status_location (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498F4FBC60 FOREIGN KEY (type_user_id) REFERENCES type_user (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D153E280 FOREIGN KEY (type_vehicule_id) REFERENCES type_vehicule (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D96D74F5E FOREIGN KEY (dispo_vehicule_id) REFERENCES dispo_vehicule (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DD725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D4827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DD725330D');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D96D74F5E');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641064D218E');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D4827B9B2');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664107E7E0A8E');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB297547F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498F4FBC60');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D153E280');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBA76ED395');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB4A4A3511');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE dispo_vehicule');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE status_facture');
        $this->addSql('DROP TABLE status_location');
        $this->addSql('DROP TABLE type_user');
        $this->addSql('DROP TABLE type_vehicule');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vehicule');
    }
}
