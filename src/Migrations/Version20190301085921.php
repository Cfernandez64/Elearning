<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190301085921 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contenu (id INT AUTO_INCREMENT NOT NULL, section_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_89C2003FD823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contenu_courses (contenu_id INT NOT NULL, courses_id INT NOT NULL, INDEX IDX_61D697BC3C1CC488 (contenu_id), INDEX IDX_61D697BCF9295384 (courses_id), PRIMARY KEY(contenu_id, courses_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003FD823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE contenu_courses ADD CONSTRAINT FK_61D697BC3C1CC488 FOREIGN KEY (contenu_id) REFERENCES contenu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contenu_courses ADD CONSTRAINT FK_61D697BCF9295384 FOREIGN KEY (courses_id) REFERENCES courses (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contenu_courses DROP FOREIGN KEY FK_61D697BC3C1CC488');
        $this->addSql('DROP TABLE contenu');
        $this->addSql('DROP TABLE contenu_courses');
    }
}
