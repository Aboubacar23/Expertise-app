<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614093036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lmesure_isolement (id INT AUTO_INCREMENT NOT NULL, mesure_isolement_id INT DEFAULT NULL, controle VARCHAR(255) DEFAULT NULL, critere DOUBLE PRECISION DEFAULT NULL, tension DOUBLE PRECISION DEFAULT NULL, valeur DOUBLE PRECISION DEFAULT NULL, conformite VARCHAR(255) DEFAULT NULL, INDEX IDX_54DB240CA65D49EE (mesure_isolement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lmesure_isolement ADD CONSTRAINT FK_54DB240CA65D49EE FOREIGN KEY (mesure_isolement_id) REFERENCES mesure_isolement (id)');
        $this->addSql('ALTER TABLE mesure_isolement DROP valeur1, DROP valeur2, DROP valeur3, DROP valeur4, DROP valeur5, DROP valeur6, DROP valeur7, DROP conformite1, DROP conformite2, DROP conformite3, DROP conformite4, DROP conformite5, DROP conformite6, DROP conformite7, DROP tension1, DROP tension2, DROP tension3, DROP tension4, DROP tension5, DROP tension6, DROP tension7');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lmesure_isolement DROP FOREIGN KEY FK_54DB240CA65D49EE');
        $this->addSql('DROP TABLE lmesure_isolement');
        $this->addSql('ALTER TABLE mesure_isolement ADD valeur1 DOUBLE PRECISION NOT NULL, ADD valeur2 DOUBLE PRECISION NOT NULL, ADD valeur3 DOUBLE PRECISION NOT NULL, ADD valeur4 DOUBLE PRECISION NOT NULL, ADD valeur5 DOUBLE PRECISION NOT NULL, ADD valeur6 DOUBLE PRECISION NOT NULL, ADD valeur7 DOUBLE PRECISION NOT NULL, ADD conformite1 VARCHAR(255) NOT NULL, ADD conformite2 VARCHAR(255) NOT NULL, ADD conformite3 VARCHAR(255) NOT NULL, ADD conformite4 VARCHAR(255) NOT NULL, ADD conformite5 VARCHAR(255) NOT NULL, ADD conformite6 VARCHAR(255) NOT NULL, ADD conformite7 VARCHAR(255) NOT NULL, ADD tension1 DOUBLE PRECISION DEFAULT NULL, ADD tension2 DOUBLE PRECISION DEFAULT NULL, ADD tension3 DOUBLE PRECISION DEFAULT NULL, ADD tension4 DOUBLE PRECISION DEFAULT NULL, ADD tension5 DOUBLE PRECISION DEFAULT NULL, ADD tension6 DOUBLE PRECISION DEFAULT NULL, ADD tension7 DOUBLE PRECISION DEFAULT NULL');
    }
}
