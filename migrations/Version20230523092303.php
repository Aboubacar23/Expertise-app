<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523092303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE controle_visuel_electrique ADD balais_longueur_shunt INT DEFAULT NULL, ADD balais_masse_longueur_shunt INT DEFAULT NULL, DROP balais_longuer_shunt, DROP balais_masse_longuer_shunt');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE controle_visuel_electrique ADD balais_longuer_shunt INT DEFAULT NULL, ADD balais_masse_longuer_shunt INT DEFAULT NULL, DROP balais_longueur_shunt, DROP balais_masse_longueur_shunt');
    }
}
