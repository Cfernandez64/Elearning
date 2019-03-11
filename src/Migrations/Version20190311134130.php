<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190311134130 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contenu (id INT AUTO_INCREMENT NOT NULL, in_cour_id INT NOT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_89C2003FFC270CED (in_cour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cour (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, duration VARCHAR(255) NOT NULL, teacher VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003FFC270CED FOREIGN KEY (in_cour_id) REFERENCES cour (id)');
        $this->addSql('ALTER TABLE lessons_contents DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE lessons_contents ADD id INT AUTO_INCREMENT NOT NULL, CHANGE lesson_id lesson_id INT DEFAULT NULL, CHANGE content_id content_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lessons_contents ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003FFC270CED');
        $this->addSql('DROP TABLE contenu');
        $this->addSql('DROP TABLE cour');
        $this->addSql('ALTER TABLE lessons_contents MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE lessons_contents DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE lessons_contents DROP id, CHANGE lesson_id lesson_id INT NOT NULL, CHANGE content_id content_id INT NOT NULL');
        $this->addSql('ALTER TABLE lessons_contents ADD PRIMARY KEY (lesson_id, content_id)');
    }
}
